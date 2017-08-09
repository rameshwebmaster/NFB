<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});
// Route::get('testing', function () {
//    $bool = DB::statement("ALTER TABLE `translations` CHANGE `translatable_type` `translatable_type` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;");
//    dd($bool);
// });

Auth::routes();

Route::get('/redis', function () {
//    $filename = uniqid('playlist_') . '.m3u8';
//    Redis::publish('nfbox:stream_start', json_encode(['filename' => $filename]));
//    Redis::set('farzin', 'something');
//    return Redis::get('farzin');
    //Farzin\Telebot\Facades\Custom::hello();
});

//Route::get('/home', 'HomeController@index');

//Route::get('redis', function () {
//    return Redis::get('name');
//});

//Route::get('publish', function () {
//    $data = [
//        'users' => [
//            'farzin',
//            'bahman',
//            'reza',
//            'maryam'
//        ],
//        'message' => [
//            'subject' => 'Very Great DISCOUNT!',
//            'body' => 'AFA a deduction from the full amount of a price or debt, as in return for prompt payment or to a special group of customers See also cash discount, trade discount. 8. Also called discount rate. the amount of interest deducted in the purchase or sale of or the loan of money on unmatured negotiable instruments.'
//        ]
//    ];
//    Redis::publish('nfbox:notification', json_encode($data));
//});

//Route::get('/tst', function () {
//    $user = \App\User::find(1);
//    return $user->tracks_system_dir;
//});

Route::get('/nfb-notifier', function () {
    return view('admin.test.notification');
});

Route::get('/checkAndroid', 'SubscriptionCheckController@checkAndroid');
Route::get('/checkIOS', 'SubscriptionCheckController@checkIOS');
Route::get('/checkCron', 'SubscriptionCheckController@cronSubscriptionValidator');



//Route::get('del', function () {
//    $path = public_path('/uploads/72822.png');
//    File::delete($path);
//});

//Route::get('mail', function () {
//    Mail::send('home', [], function($m) {
//        $m->to('sinasamani85@gmail.com', 'Sina')->subject('Your Reminder!');
//    });
//});

Route::group(['prefix' => 'nfb-admin'], function () {

    Route::get('/', 'DashboardController@dashboard')->name('dashboard');


    Route::get('users/panel', 'UsersController@listPanelUsers')->name('panelUsers');
    Route::get('users/app', 'UsersController@listAppUsers')->name('appUsers');
    Route::get('/users/create/{platform}', 'UsersController@create')->name('createUser');
    Route::post('/users/create/app', 'UsersController@storeAppUser')->name('createAppUser');
    Route::post('/users/create/panel', 'UsersController@storePanelUser')->name('createPanelUser');
    Route::get('/users/{user}/edit', 'UsersController@edit')->name('editUser');
    Route::get('/users/{user}', 'UsersController@profile')->name('profile');
    Route::patch('/users/app/{user}', 'UsersController@updateAppUser')->name('updateAppUser');
    Route::patch('/users/panel/{user}', 'UsersController@updatePanelUser')->name('updatePanelUser');
    Route::delete('/users/{user}', 'UsersController@delete');
    Route::get('/users/{user}/healthStatus', 'UsersController@healthStatus')->name('userHealthStatus');
    Route::get('/users/{user}/referred', 'UsersController@referredByUser')->name('referredByUser');

 //Added for Message Notification to Induvidual user
Route::post('user/{user}/sendNotification', 'UsersController@sendNotification')->name('sendUserNotification');
 
 
    //Added For Big Loosers
    Route::get('/losers/weight', 'LosersController@weight')->name('weightlosers');
    Route::get('/losers/waist', 'LosersController@waist')->name('waistlosers');
    Route::get('/losers/thigh', 'LosersController@thigh')->name('thighlosers');



    Route::get('/categories/{categoryType}', 'CategoriesController@index')->name('categories');
    Route::get('/categories/{categoryType}/create', 'CategoriesController@create')->name('createCategory');
    Route::post('/categories/{categoryType}/create', 'CategoriesController@store');
    Route::get('/categories/{categoryType}/{category}/edit', 'CategoriesController@edit')->name('editCategory');
    Route::patch('/categories/{category}', 'CategoriesController@update')->name('category');
    Route::delete('/categories/{category}', 'CategoriesController@delete');

    //Added For Nutrition Guidline
    Route::get('/nutritionGuid','NutritionGuideController@index')->name('nutritionsGuid');
    Route::get('/nutritionGuid/create','NutritionGuideController@create')->name('createNutritionGuid');
    Route::post('/nutritionGuid/create','NutritionGuideController@store');
    Route::get('/nutritionGuid/{guide}/edit','NutritionGuideController@edit')->name('editNutritionGuid');
    Route::patch('/nutritionGuid/{guide}','NutritionGuideController@update')->name('nutritionGuid');
    Route::delete('/nutritionGuid/{guide}','NutritionGuideController@delete')->name('deletNeutritionGuid');

    //Added For CV
    Route::get('/cv', 'CVController@index')->name('CV');
    Route::get('/cv/create', 'CVController@create')->name('createCV');
    Route::post('/cv/create', 'CVController@store');
    Route::get('/cv/{guide}/edit', 'CVController@edit')->name('editCV');
    Route::patch('/cv/{guide}', 'CVController@update')->name('CVS');
    Route::delete('/cv/{guide}', 'CVController@delete')->name('deleteCV');
 
    //Added For program Type
    Route::get('/program_type', 'ProgramTypeController@index')->name('programs_type');
    Route::get('/program_type/create', 'ProgramTypeController@create')->name('createProgramType');
    Route::post('/program_type/create', 'ProgramTypeController@store');
    Route::get('/program_type/{program}/edit', 'ProgramTypeController@edit')->name('editProgramType');
    Route::patch('/program_type/{program}', 'ProgramTypeController@update')->name('programType');
    Route::delete('/program_type/{program}', 'ProgramTypeController@delete')->name('deleteProgramType');
    Route::get('/programs_type/show', 'ProgramsController@show_program')->name('showProgramType');

    //Added for programs
    Route::get('/programs', 'ProgramsController@index')->name('programs');
    Route::get('/programs/create', 'ProgramsController@create')->name('createProgram');
    Route::post('/programs/create', 'ProgramsController@store');
    Route::get('/programs/{program}/edit', 'ProgramsController@edit')->name('editProgram');
    Route::patch('/programs/{program}', 'ProgramsController@update')->name('program');
    Route::delete('/programs/{program}', 'ProgramsController@delete');
    Route::get('/programs/{program}/table', 'ProgramsController@table')->name('programTable');
   

    Route::post('/programs/{program}/section', 'ProgramSectionsController@store')->name('createProgramSection');
    Route::post('/programs/{program}/entry', 'ProgramEntriesController@store')->name('createProgramEntry');
    Route::delete('/programentries/{entry}', 'ProgramEntriesController@delete')->name('deleteProgramEntry');


    Route::get('/programs/sections', 'ProgramSectionsController@index');
    Route::post('/programs/sections', 'ProgramSectionsController@store');
    Route::get('/programs/sections/create', 'ProgramSectionsController@create');
    Route::post('/programs/sections/create', 'ProgramSectionsController@store');
    Route::get('/programs/sections/{section}/edit', 'ProgramSectionsController@edit');
    Route::get('/programs/sections/search', 'ProgramSectionsController@search');
    Route::patch('/programs/sections/{section}', 'ProgramSectionsController@update');


    Route::get('activities', 'ActivitiesController@index')->name('activities');


    //Added Route For Transaction
    Route::get('transactions', 'TransactionsController@index')->name('transactions');
    Route::get('transactions/create', 'TransactionsController@create')->name('createTransaction');
    Route::post('transactions/create', 'TransactionsController@store');
    Route::get('/transactions/{program}/edit', 'TransactionsController@edit')->name('edittransactions');
    Route::patch('/transactions/{id}', 'TransactionsController@update')->name('transaction');
    Route::delete('/transactions/{id}', 'TransactionsController@delete')->name('deletetransaction');
   
    Route::get('report', 'TransactionsController@report')->name('reportTransaction');


    Route::get('/media', 'AttachmentsController@index')->name('media.all');
    Route::get('/media/create', 'AttachmentsController@create')->name('media.create');
    Route::post('/media/thumbnail', 'AttachmentsController@uploadThumbnail')->name('media.thumbnail');
    Route::post('/media/video', 'AttachmentsController@uploadVideo')->name('media.video');
    Route::post('/media/external', 'AttachmentsController@uploadExternalLink')->name('media.external');
    Route::get('/media/{mediaType}', 'AttachmentsController@attachmentList');
    Route::delete('/media/{media}', 'AttachmentsController@delete')->name('deleteMedia');


    Route::get('/live', 'LiveStreamController@liveStream')->name('liveStream');
    Route::post('/live/start', 'LiveStreamController@start');
    Route::post('/live/{stream}/end', 'LiveStreamController@end');

    Route::get('/{postType}', 'PostsController@index')->where('postType', '(recipes|exercises|advices|companies)')->name('posts');
    Route::get('/{postType}/create', 'PostsController@create')->where('postType', '(recipes|exercises|advices|companies)')->name('createPost');
    Route::post('/{postType}/create', 'PostsController@store')->where('postType', '(recipes|exercises|advices|companies)');
    Route::get('/{postType}/{post}/edit', 'PostsController@edit')->where('postType', '(recipes|exercises|advices|companies)')->name('editPost');
    Route::patch('/{postType}/{post}', 'PostsController@update')->where('postType', '(recipes|exercises|advices|companies)')->name('post');
    Route::delete('/{postType}/{post}', 'PostsController@delete')->where('postType', '(recipes|exercises|advices|companies)')->name('deletePost');
    Route::get('/{postType}/{post}/translation', 'PostsController@translationForm')->where('postType', '(recipes|exercises|advices|companies)')->name('translatePost');
    Route::post('/{postType}/{post}/translation', 'PostsController@storeTranslation')->where('postType', '(recipes|exercises|advices|companies)');
    Route::post('/posts/batch', 'PostsController@performBatchAction')->name('batchAction');
    Route::get('/{postType}/{post}/status', 'PostsController@status')->where('postType', '(recipes|exercises|advices|companies)')->name('statusPost');

    Route::get('info', function () {
        phpinfo();
    });

    Route::get('messages/{messageType}', 'MessagesController@showEmailForm')->where('messageType', '(email|notification)')->name('message');
    Route::post('messages/{messageType}', 'MessagesController@send')->where('messageType', '(email|notification)');

    Route::get('feedback', 'FeedbackController@index')->name('feedback');
    Route::delete('feedback/{feedback}', 'FeedbackController@delete')->name('singleFeedback');
    Route::post('feedback/batch', 'FeedbackController@batch')->name('feedbackBatchAction');

});