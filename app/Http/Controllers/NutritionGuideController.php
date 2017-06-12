<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\NutritionGuide;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NutritionGuideController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $guides = NutritionGuide::orderBy('created_at', 'desc')->paginate(15);
       
        return view('admin.nutrition_guide.index', compact('guides'));
    }

    public function create()
    {
        $isEdit = false;
        return view('admin.nutrition_guide.create', compact('isEdit'));
    }

    public function store(Request $request)
    {	
    	
		$this->validate($request, [
            'title' => 'required',
            'arabic_title' => 'required'
        ]);

        $data = $request->all();
    	
        $program = NutritionGuide::create($data);
        return redirect()->route('nutritionsGuid')->with('success', 'Nutrition Guide created successfully');
    }

    public function edit(NutritionGuide $guide)
    {
    	
        $isEdit = true;
        return view('admin.nutrition_guide.edit', compact('guide', 'isEdit'));
    }

    public function update(NutritionGuide $guide, Request $request)
    {
        // $this->validate($request, [
        //     'title' => 'required',
        //     'arabic_title' => 'required'
        // ]);

       $data = $request->all();
       $guide->update($data);
       
        return redirect()->back()->with('success', 'Nutrition Guide Updated successfully');
    }

    
    public function delete(NutritionGuide $guide)
    {
        $guide->delete();
        return back()->with('success', 'Nutrition Guide Deleted Successfully');
    }
}
