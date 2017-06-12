<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Activity;
use App\ProgramType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProgramTypeController extends Controller
{
    /**
     * ProgramsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $programs = ProgramType::orderBy('created_at', 'desc')->paginate(15);
       
        return view('admin.programs.program_type.index', compact('programs'));
    }

    public function create()
    {
        $isEdit = false;
        return view('admin.programs.program_type.create', compact('isEdit'));
    }

    public function store(Request $request)
    {

		$this->validate($request, [
            'name' => 'required'
        ]);

        $data = $request->all();
    
        $program = ProgramType::create($data);
        return redirect()->route('programs_type')->with('success', 'Program created successfully');
    }

    public function edit(ProgramType $program)
    {

        $isEdit = true;
        return view('admin.programs.program_type.edit', compact('program', 'isEdit'));
    }

    public function update(ProgramType $program, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

       $data = $request->all();
       $program->update($data);
       
        return redirect()->route('programs_type')->with('success', 'Program Updated successfully');
    }

    
    public function delete(ProgramType $program)
    {
        $program->delete();
        return back()->with('success', 'Program Deleted Successfully');
    }
}
