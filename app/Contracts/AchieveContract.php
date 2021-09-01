<?php

namespace App\Contracts;

use App\Models\User;

interface AchieveContract
{
    public function dispatchSomeEvents(User $user): void;
    public function getAchievements(User $user): array;
    public function getUnlockedAchievement(int $commentsWrittenCount, int $lessonsWatchedCount): ?string;
    public function getUnlockedAchievements(int $commentsWrittenCount, int $lessonsWatchedCount): array;
    public function getUnlockedBadge(int $achievementsCount): ?string;
    public function getNextAvailableAchievements(int $commentsWrittenCount, int $lessonsWatchedCount): array;
}
