<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{


    /**
     * ActivitiesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $activities = Activity::orderBy('created_at', 'desc')->with('user')->paginate(100);
        return view('admin.activities.index', compact('activities'));
    }

}
