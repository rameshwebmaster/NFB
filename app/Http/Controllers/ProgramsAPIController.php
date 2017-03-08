<?php

namespace App\Http\Controllers;

use App\Category;
use App\Program;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        $week = isset($request->get('week')) ? $request->get('week') : '1'; //$request->get('week') ?? '1';
        $day = isset($request->get('day')) ? $request->get('day') : '1'; //$request->get('day') ?? '1';

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
        // if not (less than two weeks), show them the program for that day
        $nutritionProgramMeta = $user->metaFor('user_nutrition_program');
        if (!$nutritionProgramMeta) {
            return response()->json(['error' => 'no_program'], 404);
        }
        $program = Program::where('id', $nutritionProgramMeta->value)->with([
            'sections' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'sections.entries' => function ($query) use ($week, $day) {
                $query->where('week', $week)->where('day', $day);
            }
        ])->first();

        $program->sections->each(function ($section) {
            $section->addTranslationItem('program_section_title', isset($section->trans('section_title')) ? $section->trans('section_title') : ""); //$section->addTranslationItem('program_section_title', $section->trans('section_title') ?? "");
            $section->entries->each(function ($entry) {
                $entry->addTranslationItem('program_entry_title', isset($entry->trans('program_entry_title')) ? $entry->trans('program_entry_title') : ""); //$entry->addTranslationItem('program_entry_title', $entry->trans('program_entry_title') ?? "");
                $entry->addTranslationItem('program_entry_quantity', isset($entry->trans('program_entry_quantity')) ? $entry->trans('program_entry_quantity') : ""); //$entry->addTranslationItem('program_entry_quantity', $entry->trans('program_entry_quantity') ?? "");
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
            $category->addTranslationItem('category_title', isset($category->trans('category_title')) ? $category->trans('category_title') : "");  //$category->addTranslationItem('category_title', $category->trans('category_title') ?? "");
            $category->addTranslationItem('category_description', isset($category->trans('category_description')) ? $category->trans('category_description') : ""); //$category->addTranslationItem('category_description', $category->trans('category_description') ?? "");
            return $category;
        }
        return response()->json(['error' => 'exercise_plan_not_found'], 404);
    }

}
