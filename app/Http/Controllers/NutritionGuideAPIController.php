<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NutritionGuide;


class NutritionGuideAPIController extends Controller
{
    public function index(){
	dd("here");
	$guide['data'] = NutritionGuide::orderBy('created_at', 'desc')->get();
       dd($guide);
    return $guide;
	
	}

}
