<?php

namespace App\Http\Controllers;

use App\Stream;
use Illuminate\Http\Request;

class StreamAPIController extends Controller
{


    public function index()
    {
        $streams = Stream::orderBy('created_at', 'desc')->where('status', 'ended')->get();

        $streams->each(function ($stream) {
            $stream->doctorName = "";
            if ($stream->doctor) {
                $stream->doctorName = $stream->doctor->first_name . " " . $stream->doctor->last_name;
            }
            $stream->url = url('/playlists/' . $stream->filename);
            $stream->date = $stream->created_at->toFormattedDateString();
            unset($stream->filename);
            unset($stream->created_at);
            unset($stream->updated_at);
            unset($stream->status);
            unset($stream->doctor);
            unset($stream->user_id);
        });
        return $streams;
    }

}
