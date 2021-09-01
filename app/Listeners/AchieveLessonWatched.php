<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Contracts\AchieveContract;
use App\Events\{
    AchievementUnlocked,
    BadgeUnlocked
};

class AchieveLessonWatched
{
    /**
     * @var AchieveContract
     */
    private $achieveContract;

    /**
     * Create the event listener.
     * @param AchieveContract $achieveContract
     *
     * @return void
     */
    public function __construct(AchieveContract $achieveContract)
    {
        $this->achieveContract = $achieveContract;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LessonWatched  $event
     * @return void
     */
    public function handle($event)
    {
        $this->achieveContract->dispatchSomeEvents($event->user);
    }
}
