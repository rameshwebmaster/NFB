<?php

namespace App\Http\Controllers;

use App\Custom\CountryList;
use App\Disease;
use App\Http\Requests\StoreAppUser;
use App\Http\Requests\StorePanelUser;
use App\Http\Requests\UpdateAppUser;
use App\Http\Requests\UpdatePanelUser;
use App\Subscription;
use App\Traits\FilterUsers;
use App\User;
use App\UserMeta;
use Carbon\Carbon;
use ConsoleTVs\Charts\Facades\Charts;
use File;
use Hash;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class UsersController extends Controller
{

    use FilterUsers;


    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listPanelUsers(Request $request)
    {
        $userTemplate = 'panel';
        $role = isset($request->get('role')) ? $request->get('role') : 'admin'; //$request->get('role') ?? 'admin';
        $search = isset($request->get('search')) ? $request->get('search') : null; //$request->get('search') ?? null;
        $query = User::orderBy('created_at', 'desc');
        if ($role) {
            $query->ofRole($role);
        }
        if ($search) {
            $query->search($search);
        }
        $users = $query->paginate(5);
        return view('admin.users.panel.index', compact('users', 'userTemplate', 'role'));
    }

    public function listAppUsers(Request $request)
    {
        $query = User::where('role', 'consumer')->latest();
        $this->filterUsers($query, $request);
        if (!is_null($request->get('new'))) {
            $query->last24Hours();
        }
        if ($request->has('year')) {
            $query->whereYear('created_at', $request->get('year'));
        }
        if ($request->has('month')) {
            $query->whereMonth('created_at', $request->get('month'));
        }
        $userTemplate = 'app';
        $users = $query->paginate(20);
        return view('admin.users.app.index', compact('users', 'userTemplate'));
    }

    public function create($platform)
    {
        $isEdit = false;
        if ($platform == 'app') {
            return view('admin.users.app_user_create', compact('isEdit'));
        } elseif ($platform == 'panel') {
            return view('admin.users.create', compact('isEdit'));
        }
    }

    public function storePanelUser(StorePanelUser $request)
    {
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveAvatar($request->file('avatar'));
        }
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $request->session()->flash('success', 'User created successfully');
        return back();
    }

    private function saveAvatar($avatar)
    {
        $file_ext = $avatar->guessClientExtension();
        $file_name = uniqid();
        $avatar_name = $file_name . '.' . $file_ext;
        $path = public_path('uploads/avatars/' . $avatar_name);
        Image::make($avatar)->fit(300, 300)->save($path);
        return $avatar_name;
    }

    public function storeAppUser(StoreAppUser $request)
    {
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveAvatar($request->file('avatar'));
        }
        $data['password'] = bcrypt($data['password']);
        $data['birth_date'] = $this->formatDate($data['birth_date']);
        $user = User::create($data);
        $data['start_date'] = $this->formatDate($data['start_date']);
        $data['expiry_date'] = $this->formatDate($data['expiry_date']);
        $subscription = new Subscription($data);
        $user->subscription()->save($subscription);
        if (!empty($data['instagram_id'])) {
            $user->addOrUpdateMeta('instagram_id', $data['instagram_id']);
        }
        if (!empty($data['phone_number'])) {
            $user->addOrUpdateMeta('phone_number', $data['phone_number']);
        }
        $user->addOrUpdateMeta('blood_type', $data['blood_type']);
        $user->addOrUpdateMeta('user_last_exercise_timestamp', Carbon::now()->subDay()->timestamp);
        $user->addOrUpdateMeta('user_exercise_count', 1);
        $user->addOrUpdateMeta('user_exercise_level', 1);
        $user->addOrUpdateMeta('user_nutrition_level', 1);
        return back()->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        $isEdit = true;
        if ($user->role == 'consumer') {
            return view('admin.users.app_user_edit', compact('user', 'isEdit'));
        } else {
            return view('admin.users.edit', compact('user', 'isEdit'));
        }
    }

    /**
     * @param User $user
     * @param UpdatePanelUser $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePanelUser(User $user, UpdatePanelUser $request)
    {

        $data = $request->except(['password']);

        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar)) {
                File::delete(public_path('uploads/avatars/' . $user->avatar));
            }
            $avatar = $request->file('avatar');
            $avatar_name = $this->saveAvatar($avatar);
            $data['avatar'] = isset($avatar_name) ? $avatar_name : ''; //
        }

        if ($request->has('password') && !empty($request->get('password'))) {
            $data['password'] = bcrypt($request->get('password'));
        }

        $user->update($data);

        return redirect()->route('editUser', ['user' => $user->id]);

    }

    public function updateAppUser(User $user, UpdateAppUser $request)
    {
        $data = $request->except(['password']);
//        dd($data["language"]);
        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar)) {
                File::delete(public_path('uploads/avatars/' . $user->avatar));
            }
            $data['avatar'] = $this->saveAvatar($request->file('avatar'));
        }
        if ($request->has('password') && !empty($request->get('password'))) {
            $data['password'] = Hash::make($request->get('password'));
        }
        $data['birth_date'] = $this->formatDate($data['birth_date']);
        $data['start_date'] = $this->formatDate($data['start_date']);
        $data['expiry_date'] = $this->formatDate($data['expiry_date']);
        $user->update($data);
        $user->subscription()->update([
            'type' => $data['type'],
            'start_date' => $data['start_date'],
            'expiry_date' => $data['expiry_date'],
        ]);
        if (isset($data['instagram_id'])) {
            $user->addOrUpdateMeta('instagram_id', $data['instagram_id']);
        }
        if (isset($data['phone_number'])) {
            $user->addOrUpdateMeta('phone_number', $data['phone_number']);
        }
        $user->addOrUpdateMeta('blood_type', $data['blood_type']);
        return back()->with('success', 'User Updated successfully');
    }

    public function profile(User $user)
    {
        if ($user->country) {
            $user->country = [
                'country_code' => $user->country,
                'country_name' => CountryList::getCountryName($user->country)
            ];
        }
        return view('admin.users.profile', compact('user'));
    }

    public function delete(User $user)
    {
        $user->metas()->delete();
        $user->delete();
        return back();
    }

    private function formatDate($date)
    {
        return Carbon::createFromFormat('m/d/Y H', $date . ' 00')->toDateTimeString();
    }

    private function saveUserDiseases(User $user, $diseases)
    {
        $ds = [];
        foreach ($diseases as $disease) {
            $ds[] = new Disease(['disease_id' => $disease]);
        }
        $user->diseases()->saveMany($ds);
    }

    public function healthStatus(User $user, Request $request)
    {
        $measure = isset($request->get('measure')) ? $request->get('measure') : 'weight'; //$request->get('measure') ?? 'weight';
        $healthStatuses = $user->healthStatuses()
            ->select($measure, 'created_at')
            ->oldest()
            ->get();
        foreach ($healthStatuses as $healthStatus) {
            $healthStatus->chart_date = $healthStatus->created_at->format('d M Y');
        }

//        $dates = $healthStatuses->pluck('chart_date')->toArray();
//        dd($healthStatuses->pluck($measure)->toArray());
        $measureChart = Charts::create('line', 'chartjs')
            ->title('User Measure Chart')
            ->labels($healthStatuses->pluck('chart_date')->toArray())
            ->values($healthStatuses->pluck($measure)->toArray())
            ->dimensions(500, 400)
            ->responsive(true);
        return view('admin.users.health_status', compact('measureChart'));
    }

    public function referredByUser(User $user)
    {
        if (!$user->isSeller) {
            return back();
        }
        $users = User::where('role', 'consumer')->whereHas('metas', function ($query) use ($user) {
            $query->where('key', 'referrer')->where('value', $user->id);
        })->paginate(20);
        return view('admin.users.panel.referred_by', compact('users'));
    }
}
