<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Transaction;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{


    /**
     * TransactionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.transactions.index', compact('transactions'));

    }

    public function create()
    {
        $isEdit = false;
        return view('admin.transactions.create', compact('isEdit'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
        ]);

        $data = $request->all();

        $data['user'] = Auth::user();

        DB::transaction(function () use ($data) {
            $transaction = Transaction::create($data);
        });

        return redirect()->route('transactions');
    }

    public function report()
    {
        $monthlyTransactions = DB::table('transactions')
            ->select(DB::raw('SUM(amount) as sum'), 'type', DB::raw('MONTH(created_at) as month'))
            ->whereRaw('YEAR(created_at) = 2017')
            ->groupBy(DB::raw('MONTH(created_at), type'))
            ->orderBy('month', 'asc')
            ->get();

        $yearlyTransactions = DB::table('transactions')
            ->select(DB::raw('SUM(amount) as sum'), 'type', DB::raw('YEAR(created_at) as year'))
            ->groupBy(DB::raw('YEAR(created_at), type'))
            ->orderBy('year', 'asc')
            ->get();
        $monthNumbers = $monthlyTransactions->pluck('month')->toArray();
        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Dec'];
        foreach ($monthNumbers as $number) {
            $months[] = $monthLabels[$number - 1];
        }
        $monthlyChart = Charts::multi('line')
            ->title('2017 Transaction Report')
            ->colors(['#03a9f3', '#fec107'])
            ->labels($months)
            ->dataset('Income', $monthlyTransactions->where('type', 'income')->pluck('sum'))
            ->dataset('Expense', $monthlyTransactions->where('type', 'expense')->pluck('sum'))
            ->dimensions(500, 400)
            ->responsive(true);

        $yearlyChart = Charts::multi('line')
            ->title('Yearly Transaction Report')
            ->colors(['#03a9f3', '#fec107'])
            ->labels(['2017', '2018', '2019'])
            ->dataset('Income', $yearlyTransactions->where('type', 'income')->pluck('sum'))
            ->dataset('Expense', $yearlyTransactions->where('type', 'expense')->pluck('sum'))
            ->dimensions(500, 400)
            ->responsive(true);
        return view('admin.transactions.report', compact('monthlyChart', 'yearlyChart'));
    }

}