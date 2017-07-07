<?php

namespace App\Http\Controllers;

use App\Stream;
use Illuminate\Http\Request;
use App\CV;
use DB;

class StreamAPIController extends Controller
{


    public function index()
    {
        $streams = Stream::orderBy('created_at', 'desc')->where('status', 'ended')->get();
       
        $streams->each(function ($stream) {
            $stream->doctorName = "";
            $stream->date_user = "";
             $stream->doctor_name_arabic = "";
            // if ($stream->doctor) {
            //     $stream->doctorName = $stream->doctor->first_name . " " . $stream->doctor->last_name;

            // // if($stream->doctor->avatar){
            // //      $stream->avatar=  url('/uploads/avatars/'.$stream->doctor->avatar);   
            // //  }else{
            // //     $stream->avatar=  '';
            // //  }
             
            // }
            $stream->doctorName ='Dr. Abdullah Al-Mutawa';
            $stream->doctor_name_arabic ='د. عبدالله المطوع'; 
            $doctor_data =  CV::select(DB::raw('CONCAT("'.url('/uploads/avatars/').'", "/", `avatar`) as avatar'))->where('role','doctor')->first();   
              
            $stream->avatar = $doctor_data->avatar;
           
            $stream->url = url('/playlists/' . $stream->filename);
            $stream->date = $stream->created_at->toFormattedDateString();
            $stream->date_user = $stream->created_at->toDateString();

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
