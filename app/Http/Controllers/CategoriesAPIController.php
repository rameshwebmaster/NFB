<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Route;
use App\Subscription;

use Tymon\JWTAuth\Facades\JWTAuth;


use Exception;

class CategoriesAPIController extends Controller
{

    private $categoryType;

    private $userType = 'free';
    /**
     * CategoriesAPIController constructor.
     */
    public function __construct()
    {
        $this->categoryType = Route::current()->getParameter('categoryType');

        try {
            if ( $user = JWTAuth::parseToken()->authenticate() ) {
                $this->userType = 'premium';
            }
        } catch (Exception $e) {
            // do nothing here
        }
        
    }

    public function categoriesList(Request $request )
    {

       
     
        $cats = Category::where('type', $this->categoryType)->orderBy('order', 'desc')->get(['id', 'title', 'type', 'description']);
      // $cats->sub = null;
        foreach($cats as $cat) {
//            dd($cat);
//            $cat->addTranslationItem('category_title', $cat->trans('category_title') ?? "");
            //$cat->addTranslationItem('category_description', $cat->trans('category_description') ?? "");
            $cat->addTranslationItem('category_title', ($cat->trans('category_title') !== null) ? $cat->trans('category_title') : "");
            $cat->addTranslationItem('category_description', ($cat->trans('category_description') !== null) ? $cat->trans('category_description') : "");
        }
          $data[$this->categoryType] = $cats->toArray();

          if( $this->userType == 'premium'){

             $user = JWTAuth::toUser();
        
          $data['subscription'] =  Subscription::where('user_id',$user->id)->get(['purchase_id','receipt'])->toArray(); 
          }
          
        // $cats = array_merge($cats->toArray(), Subscription::where('user_id',$user->id)->get(['purchase_id'])->toArray());
         //  dd($cats);
         
        return response()->json($data);
    }


}
