<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class FeedbackAPIController extends Controller
{


    /**
     * FeedbackAPIController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }


    public function store($ft, Request $request)
    {

        $body = $request->input('body');
        $type = $ft == 'normal' ? 'feedback' : 'bug';

        $user = JWTAuth::toUser();

        $feedback = Feedback::create([
            'user_id' => $user->id,
            'body' => $body,
            'type' => $type,
        ]);

        return response()->json(['success' => 'feedback_stored_successfully']);

    }
}
