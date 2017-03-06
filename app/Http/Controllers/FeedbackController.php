<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{


    /**
     * FeedbackController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $feedback = Feedback::orderBy('created_at', 'desc')->with('user')->paginate(25);
        return view('admin.feedback.index', compact('feedback'));
    }

    public function batch(Request $request)
    {
        $this->validate($request, [
            'action' => 'required',
            'batch_ids' => 'required|array',
        ]);

        $action = $request->get('action');
        $ids = $request->get('batch_ids');

        if ($action == 'delete') {
            foreach ($ids as $id) {
                Feedback::find($id)->delete();
            }
        }

        return back();
    }

    public function delete(Feedback $feedback)
    {
        $feedback->delete();
        return back();
    }

}
