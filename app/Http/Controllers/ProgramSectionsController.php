<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgramSection;
use App\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramSectionsController extends Controller
{
    public function index()
    {
        $sections = ProgramSection::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.programs.sections.index', compact('sections'));
    }

    public function create()
    {
        $isEdit = false;
        return view('admin.programs.sections.create', compact('isEdit'));
    }

    public function store(Program $program, Request $request)
    {
        $this->validate($request, [
            'title' => ' required',
            'arabic_title' => ' required',
        ]);

        $data = $request->all();
        $data['program_id'] = $program->id;
        $translation = new Translation([
            'translation_key' => 'program_section_title',
            'translation_value' => $request->input('arabic_title'),
            'translation_lang' => 'ar'
        ]);
        $section = ProgramSection::create($data);
        $section->translations()->save($translation);
        $data['id'] = $section->id;

        return redirect()->route('programTable', ['program' => $program->id])->with('success', 'section created successfully');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function search(Request $request)
    {
        $term = $request->input('term');
        $sections = ProgramSection::where('title', 'LIKE', '%' . $term . '%')->get();
        return response()->json($sections);
    }
}
