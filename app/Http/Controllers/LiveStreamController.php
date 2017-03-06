<?php

namespace App\Http\Controllers;

use App\Stream;
use Auth;
use Illuminate\Http\Request;
use Redis;

class LiveStreamController extends Controller
{


    /**
     * LiveStreamController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function liveStream()
    {
        return view('admin.live.show');
    }

    public function start()
    {
        $user = Auth::user();
        $filename = uniqid('playlist_') . '.m3u8';
        $stream = Stream::create(['filename' => $filename, 'status' => 'in-progress', 'user_id' => $user->id]);
        Redis::publish('nfbox:stream_start', json_encode(['filename' => $filename, 'doctor' => $user->first_name . ' ' . $user->last_name]));
        return ['id' => $stream->id];
    }

    public function end(Stream $stream)
    {
        $stream->status = 'ended';
        $stream->save();
        Redis::publish('nfbox:stream_end', json_encode(['status' => 'ended']));
        return 'done';
    }
}
