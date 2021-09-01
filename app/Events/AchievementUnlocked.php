<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class AchievementUnlocked
{
    use Dispatchable, SerializesModels;

    /**
     * @var string
     */
    public $achievementName;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $achievementName, User $user)
    {
        $this->$achievementName = $achievementName;
        $this->user = $user;
    }
}
