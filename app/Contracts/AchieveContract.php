<?php

namespace App\Contracts;

use App\Models\User;

interface AchieveContract
{
    public function getAchievements(User $user): array;
}
