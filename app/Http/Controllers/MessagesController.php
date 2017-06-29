<?php

namespace App\Http\Controllers;

use App\Message;
use App\Traits\FilterUsers;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use Redis;
use Log;

class MessagesController extends Controller
{

    use FilterUsers;

    function __construct()
    {
        $this->middleware('auth');
    }


    public function showEmailForm($messageType)
    {
        return view('admin.messages.send', compact('messageType'));
    }


    public function send($messageType, Request $request)
    {
        $this->validate($request, [
            'subject' => 'required',
            'body' => 'required',
            'arabic_subject' => 'required',
            'arabic_body' => 'required',
        ]);

        $query = User::where('role', 'consumer')->latest();
        $this->filterUsers($query, $request);
        $users = $query->get();

        $messageData = $request->only(['subject', 'body', 'arabic_subject', 'arabic_body']);
        $messageData['author'] = Auth::user()->id;
        $message = Message::create($messageData);

        $message->addOrUpdateTranslation('message_subject', $messageData['arabic_subject']);
        $message->addOrUpdateTranslation('message_body', $messageData['arabic_body']);

        Auth::user()->did('Sent ' . str_singular($messageType) . ' with id: ' . $message->id);

        if ($messageType == 'email') {
            $this->sendEmail($users, $message);
        } elseif ($messageType == 'notification') {
            $this->sendNotification($users, $message);
        }

        return view('admin.messages.send', compact('messageType'));
    }


    public function sendEmail($users, Message $message)
    {
        foreach ($users as $user) {
            $message->receivers()->save($user);
            if ($user->language == 'ar') {
                $subject = $message->trans('message_subject');
                $body = $message->trans('message_body');
            } else {
                $subject = $message->subject;
                $body = $message->body;
            }
            Mail::send('admin.email_templates.email', compact('body', 'user'), function ($m) use ($user, $subject) {
                $m->to($user->email, $user->first_name . ' ' . $user->last_name)->subject($subject);
            });
        }
    }

    public static function sendNotification($users, $message)
    {
        
        foreach ($users as $user) {

            $message->receivers()->save($user);

            if ($user->language == 'ar') {
                $subject = $message->trans('message_subject');
                $body = $message->trans('message_body');
            } else {
                $subject = $message->subject;
                $body = $message->body;
            }
            if ($user->hasLoggedIn()) {
                \Log::info("id : " . $user->id);
                $notificationData = [
                    'user' => [
                        'username' => $user->username,
                        'platform' => $user->lastLogin()->platform,
                        'deviceToken' => $user->lastLogin()->token,
                    ],
                    'payload' => [
                        'subject' => $subject,
                        'body' => $body,
                    ]
                ];
                Redis::publish('nfbox:notification', json_encode($notificationData));
                //Added log for to notification sent
                Log::info('Notification sent to this user ID->'.$user->id.'User Name' .$user->username.'message id->'.$message->id);
            }
        }
    }


}
