<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'UsersAPIController@login');


    Route::get('/user/self', 'UsersAPIController@userInfo');
    Route::post('/user/self', 'UsersAPIController@updateUser');
    Route::patch('/user/update', 'UsersAPIController@UpdateUserMeasures');
    Route::get('/user/update', 'UsersAPIController@canUserUpdate');
    Route::get('/user/self/stats', 'UsersAPIController@getUserStats');
    Route::get('/user/self/messages', 'UsersAPIController@getUserMessages');
    Route::patch('/user/self/password', 'UsersAPIController@updatePassword');
    Route::get('/user/self/messages/{message}', 'UsersAPIController@getUserMessage');
    Route::post('/user/register', 'UsersAPIController@register');
    Route::post('/user/self/reset', 'UsersAPIController@resetPassword');

    Route::post('/feedback/{feedbackType}', 'FeedbackAPIController@store')->where('feedbackType', '(normal|bug)');

    Route::get('/user/self/programs/nutrition', 'ProgramsAPIController@getNutritionProgram');
    Route::get('/user/self/programs/exercise', 'ProgramsAPIController@getExerciseProgram');

    Route::get('{post_type}', 'PostsAPIController@index')->where('post_type', '(recipes|advices|exercises|companies)');
    Route::get('posts/{postId}', 'PostsAPIController@single');

    Route::get('/live', 'StreamAPIController@index');


    Route::get('/categories/{categoryType}', 'CategoriesAPIController@categoriesList')
        ->where('categoryType', '(recipe_cat|exercise_cat|advice_cat|company_cat)');
});