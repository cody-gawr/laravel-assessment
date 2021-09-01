<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Repositories\UserRepositoryInterface;

class AchieveLessonWatched
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\LessonWatched  $event
     * @return void
     */
    public function handle($event)
    {
        $this->userRepository->watched($event->lesson, $event->user);
    }
}
