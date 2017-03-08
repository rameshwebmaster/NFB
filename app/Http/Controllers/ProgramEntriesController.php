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
        // Check if ajax
        if ($request->ajax()) {
            $request->request->set('title', $request->get('value'));
            $request->request->set('id', $request->get('pk'));
        }

        $this->validate($request, [
            'section' => 'required|exists:program_sections,id',
            'week' => 'required',
            'day' => 'required',
            'title' => 'required',
        ]);

        $data = $request->all();
        $data['section_id'] = $data['section'];

        if (isset($data['id']) && !empty($data['id'])) {
            $entry = ProgramEntry::find($data['id']);
            $entry->title = $request->get('title');
            $entry->save();
        } else {
            $entry = ProgramEntry::create($data);
        }

        if (!empty($request->get('arabic_title'))) {
            $entry->addOrUpdateTranslation('program_entry_title', $request->input('arabic_title'));
        }

        if (!empty($request->get('quantity_arabic'))) {
            $entry->addOrUpdateTranslation('program_entry_quantity', $request->input('quantity_arabic'));
        }

        if ($request->ajax()) {
            header('Content-type:application/json');
            if (isset($data['id']) && !empty($data['id'])) {
                $id = $entry->id ;
            } else {
                $id = $entry->section_id.'-'.$entry->week.'-'.$entry->day;
            } 
            
            return json_encode(array('success' => true, 'id' => $id, 'value' => $entry->title));
        }    
        else
            return redirect()->route('programTable', ['program' => $program->id])->with('success', 'Entry Created Successfully');
    }

    public function delete(ProgramEntry $entry)
    {
        $entry->delete();
        return back();
    }
}
