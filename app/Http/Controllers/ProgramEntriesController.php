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
            $count = ProgramEntry::where([
                    ['section_id','=',$entry->section_id],
                    ['week','=',$entry->week],
                    ['day','=',$entry->day],
                    ])->count();
            $delete = '';

            header('Content-type:application/json');
            if (isset($data['id']) && !empty($data['id'])) {
                $id = $entry->id ;
            } else {
                $id = $entry->section_id.'-'.$entry->week.'-'.$entry->day.'-'.($count-1);
                $delete = '&nbsp;<a href="javascript:void(0);" title="Delete" data-form="deleteProgramEntry'.$entry->id.'" class="btn-delete"><i class="fa fa-trash"></i></a><form id="deleteProgramEntry'.$entry->id.'" action="'.route('deleteProgramEntry', ['entry' => $entry->id]).'" method="post">'.csrf_field().method_field('delete').'</form>';
            } 
            
            return json_encode(array('success' => true, 'id' => $id, 'value' => $entry->title, 'count' => $count, 'entry' => $entry, 'delete' => $delete));
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
