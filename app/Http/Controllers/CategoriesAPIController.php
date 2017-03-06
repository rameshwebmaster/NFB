<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Route;

class CategoriesAPIController extends Controller
{

    private $categoryType;


    /**
     * CategoriesAPIController constructor.
     */
    public function __construct()
    {
        $this->categoryType = Route::current()->getParameter('categoryType');
    }

    public function categoriesList()
    {
        $cats = Category::where('type', $this->categoryType)->orderBy('order', 'desc')->get(['id', 'title', 'type', 'description']);
        foreach($cats as $cat) {
//            dd($cat);
            $cat->addTranslationItem('category_title', $cat->trans('category_title') ?? "");
            $cat->addTranslationItem('category_description', $cat->trans('category_description') ?? "");
        }
        return response()->json($cats);
    }


}
