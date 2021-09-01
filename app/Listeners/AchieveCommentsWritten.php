<?php

namespace App\Listeners;

use App\Contracts\AchieveContract;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AchieveCommentsWritten
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
     * @param  \App\Events\CommentWritten  $event
     * @return void
     */
    public function handle($event)
    {
        $this->achieveContract->dispatchSomeEvents($event->comment->user);
    }
}
