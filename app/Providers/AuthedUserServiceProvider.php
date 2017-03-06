<?php

namespace App\Providers;

use App\Custom\CountryList;
use View;
use Illuminate\Support\ServiceProvider;

class AuthedUserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        View::composer([
            'admin.users.app.index',
            'admin.posts.create',
            'admin.posts.edit',
            'admin.users.app_user_create',
            'admin.users.app_user_edit',
            'admin.messages.send'
        ], function ($view) {
            $view->with('countries', CountryList::$countryList);
        });

        View::composer('*', function ($view) {
            $view->with('currentUser', \Auth::user());
        });

        View::composer('*', function ($view) {
            $postTypes = [
                'advices' => [
                    'title' => 'Advices',
                    'category' => 'advice_cat',
                    'icon' => 'fa fa-user',
                ],
                'exercises' => [
                    'title' => 'Exercises',
                    'category' => 'exercise_cat',
                    'icon' => 'fa fa-user',
                ],
                'companies' => [
                    'title' => 'Companies',
                    'category' => 'company_cat',
                    'icon' => 'fa fa-user',
                ],
                'recipes' => [
                    'title' => 'Recipes',
                    'category' => 'recipe_cat',
                    'icon' => 'fa fa-user',
                ],
            ];
            $view->with('postTypes', $postTypes);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
