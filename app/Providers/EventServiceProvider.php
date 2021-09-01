<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\{
    CommentWritten,
    LessonWatched
};
use App\Listeners\{
    AchieveCommentsWritten,
    AchieveLessonWatched
};

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            AchieveCommentsWritten::class
        ],
        LessonWatched::class => [
            AchieveLessonWatched::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
