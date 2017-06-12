<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\CV;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;

class CVController extends Controller
{
    /**
     * CVController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $guides = CV::orderBy('created_at', 'desc')->paginate(15);
       
        return view('admin.cvs.index', compact('guides'));
    }

    public function create()
    {
        $isEdit = false;
        return view('admin.cvs.create', compact('isEdit'));
    }

    public function store(Request $request)
    {	
    	//dd($request->all());

		$this->validate($request, [
            'name' => 'required',
            'role' => 'required',
            'avatar' =>'mimes:jpeg,jpg,png|max:5000'
        ]);

        $data = $request->all();
    	
    	if($request->hasFile('avatar')) {
            $data['avatar'] = $this->saveAvatar($request->file('avatar'));

        }

        $program = CV::create($data);
        return redirect()->route('CV')->with('success', 'CV created successfully');
    }

    private function saveAvatar($avatar)
    {
		$file_ext = $avatar->guessClientExtension();
        $file_name = uniqid();
        $avatar_name = $file_name . '.' . $file_ext;
        $path = public_path('uploads/avatars/' . $avatar_name);

        Image::make($avatar)->resize(360, 286)->save($path);
        return $avatar_name;
    }

    public function edit(CV $guide)
    {
    	
        $isEdit = true;
        return view('admin.cvs.edit', compact('guide', 'isEdit'));
    }

    public function update(cv $guide, Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'role' => 'required',
            'avatar' =>'mimes:jpeg,jpg,png|max:5000'
        ]);

       $data = $request->all();
       if($request->hasFile('avatar')) {
           $data['avatar'] = $this->saveAvatar($request->file('avatar'));

       }

       $guide->update($data);
       
       return redirect()->route('CV')->with('success', 'CV Updated successfully');
    }

    
    public function delete(CV $guide)
    {
    	
        $guide->delete();
        return back()->with('success', 'CV Deleted Successfully');
    }
}
