<?php

namespace App\Http\Controllers;

use App\Activity;
use App\HealthStatus;
use App\Program;
use App\ProgramSection;
use App\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProgramsController extends Controller
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
        $programs = Program::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        $isEdit = false;
        return view('admin.programs.create', compact('isEdit'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $data = $request->all();
        $data['interval_type'] = 'week';
        $data['interval_count'] = 2;
        $data['author'] = Auth::user();
        $data['type'] = 'nutrition';
        if (!$request->has('disease')) {
            $data['diseases'] = '0,0,0,0,0';
        } else {
            $data['diseases'] = HealthStatus::getDiseaseString($data['disease']);
        }
        DB::transaction(function () use ($data) {
            $program = Program::create($data);
            $sections = [
                'Breakfast' => 'وجبة افطار',
                'First Snack' => 'وجبة خفيفة الأولى',
                'Lunch' => 'غداء',
                'Second Snack' => 'وجبة خفيفة الثانية',
                'Dinner' => 'وجبة عشاء'];
            foreach ($sections as $sectionTitle => $arabicSectionTitle) {
                $this->createSection($program, $sectionTitle, $arabicSectionTitle);
            }
        });

        return redirect()->route('programs')->with('success', 'Program created successfully');
    }

    public function edit(Program $program)
    {
        $isEdit = true;
        return view('admin.programs.edit', compact('program', 'isEdit'));
    }

    public function update(Program $program, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $data = $request->all();
        if (!$request->has('disease')) {
            $data['diseases'] = '0,0,0,0,0';
        } else {
            $data['diseases'] = HealthStatus::getDiseaseString($data['disease']);
        }
        $program->update($data);

        return redirect()->route('programs')->with('success', 'Program Updated successfully');
    }

    public function table($program, Request $request)
    {
        $week = isset($request->get('w')) ? $request->get('w') : '1'; //$request->get('w') ?? '1';
        $program = Program::where('id', $program)->with(['sections' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'sections.entries' => function ($query) use ($week) {
            $query->where('week', $week);
        }])->first();
        //$program->sections()->orderBy('created_at', 'desc')->with('entries')->get();
        return view('admin.programs.table', compact('program', 'week'));
    }

    private function createSection(Program $program, $sectionTitle, $arabicSectionTitle)
    {
        $section = new ProgramSection(['title' => $sectionTitle]);
        $program->sections()->save($section);
        $section->addOrUpdateTranslation('section_title', $arabicSectionTitle);
    }

    public function delete(Program $program)
    {
        $program->delete();
        return back()->with('success', 'Program Deleted Successfully');
    }
}
