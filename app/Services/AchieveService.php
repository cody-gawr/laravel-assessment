<?php

namespace App\Services;

use App\Contracts\AchieveContract;
use App\Models\User;

class AchieveService implements AchieveContract
{
    public function getAchievements(User $user): array
    {
        $commentsWrittenCount = $user->comments()->count();
        $lessonsWatchedCount = $user->watched()->count();
        // Load all constants according to achievements
        $lessonsAchievements = collect(config('constants.achievements.lessons'));
        $commentsAchievements = collect(config('constants.achievements.comments'));
        $badgesAchievements = collect(config('constants.achievements.badges'));

        $unlockedCommentsWrittenAchievements = $commentsAchievements->filter(function ($item) use ($commentsWrittenCount) {
            return $item['count'] <= $commentsWrittenCount;
        });
        $unlockedLessonsWatchedAchievements = $lessonsAchievements->filter(function ($item) use ($lessonsWatchedCount) {
            return $item['count'] <= $lessonsWatchedCount;
        });
        $unlockedAchievements = $unlockedCommentsWrittenAchievements->merge($unlockedLessonsWatchedAchievements)->pluck('message');
        $achievementsCount = $unlockedAchievements->count();

        $nextAvailableAchievements = collect();
        $nextAvailableCommentsWrittenAchievementItem = $commentsAchievements->first(function ($item) use ($commentsWrittenCount) {
            return $item['count'] > $commentsWrittenCount;
        });
        $nextAvailableLessonsWatchedAchievementItem = $lessonsAchievements->first(function ($item) use ($lessonsWatchedCount) {
            return $item['count'] > $lessonsWatchedCount;
        });
        $nextAvailableAchievements->push($nextAvailableCommentsWrittenAchievementItem);
        $nextAvailableAchievements->push($nextAvailableLessonsWatchedAchievementItem);
        // all entries of the collection that are equivalent to null will be removed:
        $nextAvailableAchievements = $nextAvailableAchievements->filter()->pluck('message');

        $currentBadgeItem = $badgesAchievements->last(function ($item) use ($achievementsCount) {
            return $item['achievements_count'] <= $achievementsCount;
        });
        $nextBadgeItem = $badgesAchievements->first(function ($item) use ($achievementsCount) {
            return $item['achievements_count'] > $achievementsCount;
        });
        $currentBadge = $currentBadgeItem['message'] ?? null;
        $nextBadge = $nextBadgeItem['message'] ?? null;
        $remaingToUnlockNextBadge = is_null($nextBadgeItem) ? 0 : $nextBadgeItem['achievements_count'] - $achievementsCount;

        $achievements = [
            'unlocked_achievements' => $unlockedAchievements->toArray(),
            'next_available_achievements' => $nextAvailableAchievements->toArray(),
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaing_to_unlock_next_badge' => $remaingToUnlockNextBadge
        ];

        return $achievements;
    }
}
