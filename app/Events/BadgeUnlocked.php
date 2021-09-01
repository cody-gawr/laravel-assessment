<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class BadgeUnlocked
{
    use Dispatchable, SerializesModels;

    /**
     * @var string
     */
    public $badgeName;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $badgeName, User $user)
    {
        $this->badgeName = $badgeName;
        $this->user = $user;
    }
}
