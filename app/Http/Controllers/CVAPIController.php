<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CV;
use DB;

class CVAPIController extends Controller
{
    
    public function index(Request $request){
    
    //url('/uploads/avatars/') 
    if($request->header('id')){


		    $token = $request->header('id');
		    $stored_token = 'scott';
		    $result = md5($stored_token);
		    
			if($result == $token){

				$doctor_data['data'] =  CV::select('id','name','role','description',DB::raw('CONCAT("'.url('/api/v1/imageview').'", "/", `avatar`) as avatar'))->get();
		    	return $doctor_data;
			}
			 return response()->json(['error' => 'token_mismatch'], 404);
			
		}

		return response()->json(['error' => 'token_not_found'], 404);

	}

}
