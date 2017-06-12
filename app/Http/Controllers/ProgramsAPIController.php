<?php

namespace App\Http\Controllers;

use App\Category;
use App\Program;
use App\ProgramType;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use DB;
use Log;

class ProgramsAPIController extends Controller
{


    /**
     * ProgramsAPIController constructor.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function getNutritionProgram(Request $request)
    {

       $week = ($request->get('week') !== null) ? $request->week : '1'; //$request->get('week') ?? '1';
     
        $day = ($request->get('day') !== null) ? $request->day : '1'; //$request->get('day') ?? '1';

        $user = JWTAuth::toUser();
    
        // if user has not updated tell them to update first
        if (!$user->hasUpdatedMeasuresAtLeastOnce()) {
            return response()->json(['error' => 'has_not_updated_measures'], 401);
        }
        // if user has updated then
        // if more than two weeks has past since last update tell them to update again
        if ($user->daysSinceLastUpdate() > 14) {
            return response()->json(['error' => 'should_update_measures'], 402);
        }
       
       //this will return current program type '$currentProgramType->type'
        $currentProgramType = ProgramType::getCurrentProgramType();
        if(!$currentProgramType) {
            return response()->json(['error' => 'no_current_active_program_type'], 405);
        }
       
        //if not (less than two weeks), show them the program for that day
        $nutritionProgramMeta = $user->metaFor('user_nutrition_program');
     
        if(!$nutritionProgramMeta) {
             //Added log for program not found in meta table
             Log::info('Program Not found in Meta table for this User Id->'.$user->id.'-User name->'.$user->username);
        
            return response()->json(['error' => 'no_program'], 404);
        }else{

            //this will return program type of current porgram id '$currentProramIdType->type'
            $currentProgramIdType = Program::getProgramsIdType($nutritionProgramMeta->value);
            if(!$currentProgramIdType) {
            
            //Added log for program Id not found in Program table
             Log::info('This Program Id does not exists in Program table for this User Id->'.$user->id.'-User name->'.$user->username.'-Program ID-'.$nutritionProgramMeta->value);
            return response()->json(['error' => 'no_program'], 404);
            
            }  

            //this will use for fetch program data
            $program_id_to_fetch = $nutritionProgramMeta->value;  

            //this is for check if type is same or not and fetch program on that basis
            if($currentProgramIdType->type != $currentProgramType->type_value){

                $new_program_id = DB::table('programs as program_new')
                            ->select('program_new.id')
                            ->leftjoin('programs as program_old',function($join){
                             $join->on("program_old.level","=","program_new.level")
                            ->on("program_old.bmi","=","program_new.bmi")
                            ->on("program_old.diseases","=","program_new.diseases")
                            ->on("program_old.id","<>","program_new.id");
                            })->where('program_old.id','=',$nutritionProgramMeta->value)->first();

                if(!$new_program_id) {

                   //Added log for program Id not found in different NP type
             Log::info('New Nutrition Program Type not found. User ID->'.$user->id.'-User name->'.$user->username.'-Old Program ID-'.$nutritionProgramMeta->value); 
                   return response()->json(['error' => 'no_program_found'], 406);            
                }

                $program_id_to_fetch = $new_program_id->id;
                $user->addOrUpdateMeta('user_nutrition_program', $program_id_to_fetch);           
            }
        
        
            }
        $program = Program::where('id',$program_id_to_fetch)->with([
            'sections' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'sections.entries' => function ($query) use ($week, $day) {
                $query->where('week', $week)->where('day', $day);
            }
        ])->first();
       
        if(!$program){

              //Added log for program details not found.
             Log::info('Nutrition Program details not found. User ID->'.$user->id.'-User name->'.$user->username.'-Program ID-'.$program_id_to_fetch);

             return response()->json(['error' => 'no_program'], 404);
        }

        $program->sections->each(function ($section) {
            $section->addTranslationItem('program_section_title', ($section->trans('section_title') !== null) ? $section->trans('section_title') : ""); //$section->addTranslationItem('program_section_title', $section->trans('section_title') ?? "");
            $section->entries->each(function ($entry) {
                $entry->addTranslationItem('program_entry_title', ($entry->trans('program_entry_title') !== null) ? $entry->trans('program_entry_title') : ""); //$entry->addTranslationItem('program_entry_title', $entry->trans('program_entry_title') ?? "");
                $entry->addTranslationItem('program_entry_quantity', ($entry->trans('program_entry_quantity') !== null) ? $entry->trans('program_entry_quantity') : ""); //$entry->addTranslationItem('program_entry_quantity', $entry->trans('program_entry_quantity') ?? "");
            });
        });

        return $program->sections;
    }

    public function getExerciseProgram()
    {
        $user = JWTAuth::toUser();
        $exerciseLevel = $user->metaFor('user_exercise_level')->value;
        $category = Category::where('type', 'exercise_cat')->where('order', $exerciseLevel)->first();
        if ($category) {
            $category->addTranslationItem('category_title', ($category->trans('category_title') !== null) ? $category->trans('category_title') : "");  //$category->addTranslationItem('category_title', $category->trans('category_title') ?? "");
            $category->addTranslationItem('category_description', ($category->trans('category_description') !== null) ? $category->trans('category_description') : ""); //$category->addTranslationItem('category_description', $category->trans('category_description') ?? "");
            return $category;
        }
        return response()->json(['error' => 'exercise_plan_not_found'], 404);
    }

   

}
