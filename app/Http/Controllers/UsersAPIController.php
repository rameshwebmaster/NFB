<?php

namespace App\Http\Controllers;

use App\HealthStatus;
use App\Http\Requests\ApiRegisterRequest;
use App\Login;
use App\Program;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Psr7\UploadedFile;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Subscription;
use DB;
use Validator;

class UsersAPIController extends Controller
{


    /**
     * UsersAPIController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => [
            'login', 'register', 'resetPassword'
        ]]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $credentials['role'] = 'consumer';
        try {
            $token = JWTAuth::attempt($credentials);
            
            if (!$token) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = User::where('username', $credentials['username'])->first();
        $now = Carbon::now();
        // if ($user->subscription->start_date->gt($now) || $user->subscription->expiry_date->lt($now)) {
        //     return response()->json(['error' => 'login_not_possible'], 402);
        // }
        $login = new Login(['platform' => $request->get('platform'), 'token' => $request->get('device_token')]);
        $user->logins()->save($login);
        return response()->json(compact('token'));
    }


    public function userInfo(Request $request)
    {
        $user = JWTAuth::toUser();
        $metas = $user->metas->keyBy('key');
        $avatar = isset($user->avatar) ? $user->avatar : 'default.jpg'; //$user->avatar ?? 'default.jpg';
        $data = [
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'username' => $user->username,
            'avatar' => url('/api/v1/user/avatar/' . $avatar),
            'country' => $user->country,
            'language' => $user->language,
            'birth_date' => $user->birth_date ? $user->birth_date->toDateTimeString() : null,
            'instagram_id' => isset($metas['instagram_id']) ? $metas['instagram_id']->value : null,
            'phone_number' => isset($metas['phone_number']) ? $metas['phone_number']->value : null,
            'doctor_name' =>'Dr. Abdullah Al-Mutawa',
            'trainer_name'=>'Viktoriia Dudko',
            'user_exercise_level'  => isset($metas['user_exercise_level']) ? $metas['user_exercise_level']->value : null,
            'hasUpdatedInfo' => false,
            'weight_chart' => [],
            'health_status' => $user->healthStatuses()->select('id','user_id','weight','height','diseases','waist_circumference','thighs_circumference')->orderBy('id', 'desc')->first(),
            'unread' => $user->messages()->wherePivot('read', 0)->count(),
            'subscription' => $user->subscription()->select('id', 'user_id', 'expiry_date', 'start_date', 'type', 'status', 'created_at')->first(),
        ];
        return response()->json($data);
    }

    public function updateUser(Request $request)
    {
        $user = JWTAuth::toUser();
        $data = $request->except(['avatar']);
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveAvatar($request->file('avatar'));
        }
        $user->update($data);
        if (!empty($data['instagram_id'])) {
            $user->addOrUpdateMeta('instagram_id', $data['instagram_id']);
        }
        if (!empty($data['phone_number'])) {
            $user->addOrUpdateMeta('phone_number', $data['phone_number']);
        }
        return response()->json(['success' => 'updated_successfully']);
    }

    public function updateUserMeasures(Request $request)
    {
        Log::info('Request: ' . $request);
        $user = JWTAuth::toUser();
        $statusData = $request->all();
        if (!$request->has('disease')) {
            $statusData['diseases'] = '0,0,0,0,0';
        } else {
            $statusData['diseases'] = User::diseaseString($request->disease);
        }
        $status = new HealthStatus($statusData);
        $user->healthStatuses()->save($status);
        $user->addOrUpdateMeta('last_health_status_update', Carbon::now()->timestamp);
        $bmi = $statusData['weight'] / pow($statusData['height'] / 100, 2);
        if ($bmi < 16) {
            $bmiIndex = 0;
        } elseif ($bmi >= 16 && $bmi < 17) {
            $bmiIndex = 1;
        } elseif ($bmi >= 17 && $bmi < 18.5) {
            $bmiIndex = 2;
        } elseif ($bmi >= 18.5 && $bmi < 25) {
            $bmiIndex = 3;
        } elseif ($bmi >= 25 && $bmi < 30) {
            $bmiIndex = 4;
        } elseif ($bmi >= 30 && $bmi < 35) {
            $bmiIndex = 5;
        } elseif ($bmi >= 35 && $bmi < 40) {
            $bmiIndex = 6;
        } elseif ($bmi >= 40) {
            $bmiIndex = 7;
        }
        $level = $user->metaFor('user_nutrition_level');

     $program = Program::where('bmi', $bmiIndex)->where('level', $level->value)->where('diseases', $statusData['diseases'])->first();
      
     if ($program) {
            $user->addOrUpdateMeta('user_nutrition_level', $level->value + 1);
            $user->addOrUpdateMeta('user_nutrition_program', $program->id);
            $user->addOrUpdateMeta('user_bim_index', $bmiIndex);
        }
       
        return response()->json(['success' => 'info_updated']);
    }

    public function canUserUpdate()
    {
        $user = JWTAuth::toUser();
        $lastUpdate = $user->hasUpdatedMeasuresAtLeastOnce();
        if ($lastUpdate) {
            $then = Carbon::createFromTimestamp($lastUpdate->value);
            $now = Carbon::now();
            $diff = $now->diffInDays($then);

            if ($diff >= 14) {
                return response()->json(['success' => 'allowed_to_update']);
            } else {
                return response()->json(['error' => 'not_allowed_to_update'], 400);
            }
        }
        return response()->json(['success' => 'allowed_to_update']);
    }


    /**
     * @param Request $request
     * @internal User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserStats(Request $request)
    {
        $stat = $request->get('measure');

        if (!HealthStatus::isvalidMeasure($stat)) {
            return response()->json(['error' => 'no_such_measure'], 400);
        }
        $user = JWTAuth::toUser();
        $history = $user->healthHistory($stat);
        $history->each(function ($status) {
            $status->update_time = $status->created_at->format('d M');
        });
        return response()->json($history);
    }


    public function getUserMessages()
    {
        $user = JWTAuth::toUser();
        $messages = $user
            ->messages()
            ->orderBy('sent_at', 'desc')
            ->withPivot('sent_at', 'read')
            ->paginate(10);
        $messages->each(function ($message) {
            $message->read = $message->pivot->read;
            $message->sent_at = Carbon::createFromFormat('Y-m-d H:i:s', $message->pivot->sent_at)->format('d M Y');
            $message->addTranslationItem('message_subject', ($message->trans('message_subject') !== null) ? $message->trans('message_subject') : ""); //$message->addTranslationItem('message_subject', $message->trans('message_subject') ?? "");
            $message->addTranslationItem('message_body', ($message->trans('message_body') !== null) ? $message->trans('message_body') : ""); //$message->addTranslationItem('message_body', $message->trans('message_body') ?? "");
        });
        return response()->json($messages);
    }

    public function getUserMessage($message)
    {
        $user = JWTAuth::toUser();
        $user->messages()->updateExistingPivot($message, ['read' => 1]);
        $message = $user->messages()->where('messages.id', $message)->withPivot('sent_at', 'read')->first();
        $message->read = $message->pivot->read;
        $message->sent_at = Carbon::createFromFormat('Y-m-d H:i:s', $message->pivot->sent_at)->format('d M Y');
        $message->addTranslationItem('message_subject', ($message->trans('message_subject') !== null) ? $message->trans('message_subject') : ""); //$message->addTranslationItem('message_subject', $message->trans('message_subject') ?? "");
        $message->addTranslationItem('message_body', ($message->trans('message_body') !== null) ? $message->trans('message_body') : ""); //$message->addTranslationItem('message_body', $message->trans('message_body') ?? "");
        return $message;
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'new' => 'required'
        ]);
        $user = JWTAuth::toUser();
        $data = $request->only('new');
        $user->password = Hash::make($data['new']);
        $user->save();
        return response()->json(['success' => 'password_changed_successfully']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'gender' => 'required|in:1,2',
            'blood_type' => 'required',
            'language' => 'required',
            'birth_date'=>'required',
            'password'=>'required',
            'platform'=>'required',

        ]);

        //Check whether validation is failed or passed
        if($validator->fails()){
            //Redirect back with validation errors
            return response()->json(['error' => $validator->errors()], 400);
        }

        $data = $request->except(['avatar']);
        $data['role'] = 'consumer';
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveAvatar($request->file('avatar'));
        }
        $data['password'] = bcrypt($data['password']);
//        $data['birth_date'] = $this->formatDate($data['birth_date']);
        $user = User::create($data);
//        $data['start_date'] = $this->formatDate($data['start_date']);
//        $data['expiry_date'] = $this->formatDate($data['expiry_date']);
//        $subscription = new Subscription($data);
//        $user->subscription()->save($subscription);
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

        $credentials = $request->only('username', 'password');
        $credentials['role'] = 'consumer';
        try {
            $token = JWTAuth::attempt($credentials);
            
            if (!$token) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $login = new Login(['platform' => $request->get('platform'), 'token' => $request->get('device_token')]);
        $user->logins()->save($login);

        //return response()->json(compact('token'));
        return ['success' => 'user_created_successfully','token'=>$token];
    }


    private function saveAvatar($avatar)
    {
        $file_ext = $avatar->getClientOriginalExtension();
        $file_name = uniqid();
        $avatar_name = $file_name . '.' . $file_ext;
        $path = public_path('uploads/avatars/' . $avatar_name);
        Image::make($avatar)->fit(300, 300)->save($path);
        return $avatar_name;
    }

    public function resetPassword(Request $request)
    {
        $email = $request->get('email');
        $user = User::where('email', $email)->where('role', 'consumer')->first();
        if (!$user) {
            return response()->json(['error' => 'no_user_with_that_email'], 404);
        }
        $password = uniqid();
        Mail::send('admin.email_templates.reset', compact('user', 'password'), function ($m) use ($user, $password) {
            $m->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Reset Password');
            $user->password = bcrypt($password);
            $user->save();
        });
    }

    public function updateSubscription(Request $request){

         $validator = Validator::make($request->all(), [
            // 'user_id' => 'required',
            'start_date' => 'required',
            'expiry_date' => 'required',
            'type' => 'required',
            'status'=>'required',   
            //'receipt' => 'required',
            //'purchase_id'=>'required',
        ]);
    
        $user = JWTAuth::toUser(); 
          //Check whether validation is failed or passed
        if($validator->fails()){
            //Redirect back with validation errors
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $data['user_id'] = $user->id;
        $data['type']=$request->type;
        $data['receipt']=$request->receipt;
        $data['purchase_id']=$request->purchase_id;
        $data['start_date'] = date("Y-m-d H:i:s",strtotime($request->start_date));
        $data['expiry_date'] = date("Y-m-d H:i:s",strtotime($request->expiry_date));
        $data['status'] = $request->status;
       
        $sub_id_db = Subscription::select('id')->where('user_id', $user->id)->first();
   
        if(isset($sub_id_db->id)){

           $user->subscription()->update($data);
         
        }else{
             $subscription = new Subscription($data);
            $user->subscription()->save($subscription);
         
        }
       
        return ['success' => 'user_subscribed_successfully']; 
    }

    public function getAllDoctors(Request $request){
        $role = "Doctor";
        $user = JWTAuth::toUser();
        $doctor_data =  User::select('id','username','email','first_name','last_name','country','gender','birth_date','language',DB::raw('CONCAT("'.url('/').'", "/", `avatar`) as avatar'))->where('role','LIKE','%'.$role.'%')->get();
       
        return response()->json($doctor_data);
    }

    public function getUserSubType(Request $request){
        $user = JWTAuth::toUser();

        $subs_user_id =Subscription::select('type','start_date','expiry_date')->where('user_id',$user->id)->first();
        //dd($subs_user_id);
         return response()->json($subs_user_id);
    }

    public function AllStatus(Request $request){

        //to know users last actions user_nutrition_program,user_nutrition_level,last_health_status_update,user_bim_index
        $data = array();
        $user = JWTAuth::toUser();
        $data['user_nutrition_program'] = $user->metaFor('user_nutrition_program');
        $data['user_nutrition_level'] = $user->metaFor('user_nutrition_level');
        $data['last_health_status_update'] = $user->metaFor('last_health_status_update');
        $data['user_bim_index'] = $user->metaFor('user_bim_index');
       return response()->json($data);
    }

}
