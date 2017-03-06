<?php

namespace App\Providers;

use App\Activity;
use App\Attachment;
use App\Feedback;
use App\Message;
use App\Policies\ActivityPolicy;
use App\Policies\FeedbackPolicy;
use App\Policies\LiveStreamPolicy;
use App\Policies\MediaPolicy;
use App\Policies\MessagePolicy;
use App\Policies\PostPolicy;
use App\Policies\ProgramPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserPolicy;
use App\Post;
use App\Program;
use App\Stream;
use App\Transaction;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
        Transaction::class => TransactionPolicy::class,
        Message::class => MessagePolicy::class,
        Attachment::class => MediaPolicy::class,
        Feedback::class => FeedbackPolicy::class,
        User::class => UserPolicy::class,
        Stream::class => LiveStreamPolicy::class,
        Program::class => ProgramPolicy::class,
        Activity::class => ActivityPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
