<?php

namespace App\Contracts;

use App\Models\User;

interface ArchieveContract
{
    public function getUnlockedAchievements(User $user): array;
    public function getNextAvailableAchievements(User $user): array;
    public function getCurrentBadge(User $user): array;
    public function getRemainingToUnlockNextBadge(User $user): int;
}
