<?php

namespace App\Http\Controllers;

use App\Program;
use App\ProgramEntry;
use App\Translation;
use Illuminate\Http\Request;

class ProgramEntriesController extends Controller
{


    public function store(Program $program, Request $request)
    {
        $this->validate($request, [
            'section' => 'required|exists:program_sections,id',
            'week' => 'required',
            'day' => 'required',
            'title' => 'required',
        ]);

        $data = $request->all();
        $data['section_id'] = $data['section'];

        $entry = ProgramEntry::create($data);

        if (!empty($request->get('arabic_title'))) {
            $entry->addOrUpdateTranslation('program_entry_title', $request->input('arabic_title'));
        }

        if (!empty($request->get('quantity_arabic'))) {
            $entry->addOrUpdateTranslation('program_entry_quantity', $request->input('quantity_arabic'));
        }

        return redirect()->route('programTable', ['program' => $program->id])->with('success', 'Entry Created Successfully');
    }


}
