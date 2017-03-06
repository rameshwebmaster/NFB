<?php

namespace App\Providers;

use App\Category;
use App\Custom\CountryList;
use App\Message;
use App\Post;
use App\Program;
use App\ProgramEntry;
use App\ProgramSection;
use App\User;
use Carbon\Carbon;
use Farzin\Telebot\CustomClass;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'post' => Post::class,
            'category' => Category::class,
            'program' => Program::class,
            'program_section' => ProgramSection::class,
            'program_entry' => ProgramEntry::class,
            'user' => User::class,
            'message' => Message::class,
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

        $this->app->bind('custom', function() {
            return new CustomClass();
        });
    }
}
