<?php

namespace App\Services;

use App\Contracts\AchieveContract;
use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Collection;

class AchieveService implements AchieveContract
{
    /**
     * @var Collection
     */
    private $lessonsAchievements, $commentsAchievements, $badgesAchievements;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * AchieveService constructor
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        // Load all constants according to achievements
        $this->lessonsAchievements = collect(config('constants.achievements.lessons'));
        $this->commentsAchievements = collect(config('constants.achievements.comments'));
        $this->badgesAchievements = collect(config('constants.achievements.badges'));
        $this->userRepository = $userRepository;
    }

    /**
     * @param User $user
     * @return void
     */
    public function dispatchSomeEvents(User $user): void
    {
        $commentsAndLessonsCount = $this->userRepository->getCommentsAndLessonsCount($user);

        $unlockedAchievements = $this->getUnlockedAchievements($commentsAndLessonsCount['comments'], $commentsAndLessonsCount['lessons']);
        $unlockedAchievementName = $this->getUnlockedAchievement($commentsAndLessonsCount['comments'], $commentsAndLessonsCount['lessons']);
        $unlockedBadgeName = $this->getUnlockedBadge(count($unlockedAchievements));

        if ($unlockedAchievementName) {
            AchievementUnlocked::dispatch($unlockedAchievementName, $user);
        }

        if ($unlockedBadgeName) {
            BadgeUnlocked::dispatch($unlockedBadgeName, $user);
        }
    }

    /**
     * @param User $user
     * @return array
     */
    public function getAchievements(User $user): array
    {
        $commentsAndLessonsCount = $this->userRepository->getCommentsAndLessonsCount($user);

        $unlockedAchievements = $this->getUnlockedAchievements($commentsAndLessonsCount['comments'], $commentsAndLessonsCount['lessons']);
        $nextAvailableAchievements = $this->getNextAvailableAchievements($commentsAndLessonsCount['comments'], $commentsAndLessonsCount['lessons']);
        $achievementsCount = count($unlockedAchievements);

        $currentBadgeItem = $this->badgesAchievements->last(function ($item) use ($achievementsCount) {
            return $item['achievements_count'] <= $achievementsCount;
        });
        $nextBadgeItem = $this->badgesAchievements->first(function ($item) use ($achievementsCount) {
            return $item['achievements_count'] > $achievementsCount;
        });
        $currentBadge = $currentBadgeItem['message'] ?? null;
        $nextBadge = $nextBadgeItem['message'] ?? null;
        $remaingToUnlockNextBadge = is_null($nextBadgeItem) ? 0 : $nextBadgeItem['achievements_count'] - $achievementsCount;

        $achievements = [
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaing_to_unlock_next_badge' => $remaingToUnlockNextBadge
        ];

        return $achievements;
    }

    /**
     * @param int $commentsWrittenCount
     * @param int int $lessonsWatchedCount
     * @return array
     */
    public function getNextAvailableAchievements(int $commentsWrittenCount, int $lessonsWatchedCount): array
    {
        $nextAvailableAchievements = collect();
        $nextAvailableCommentsWrittenAchievementItem = $this->commentsAchievements->first(function ($item) use ($commentsWrittenCount) {
            return $item['count'] > $commentsWrittenCount;
        });
        $nextAvailableLessonsWatchedAchievementItem = $this->lessonsAchievements->first(function ($item) use ($lessonsWatchedCount) {
            return $item['count'] > $lessonsWatchedCount;
        });
        $nextAvailableAchievements->push($nextAvailableCommentsWrittenAchievementItem);
        $nextAvailableAchievements->push($nextAvailableLessonsWatchedAchievementItem);
        // all entries of the collection that are equivalent to null will be removed:
        $nextAvailableAchievements = $nextAvailableAchievements->filter()->pluck('message');
        return $nextAvailableAchievements->toArray();
    }

    /**
     * @param User $user
     * @return string|null
     */
    public function getUnlockedAchievement(int $commentsWrittenCount, int $lessonsWatchedCount): ?string
    {
        $unlockedCommentsWrittenAchievementItem = $this->commentsAchievements->filter(function ($item) use ($commentsWrittenCount) {
            return $item['count'] === $commentsWrittenCount;
        });
        $unlockedLessonsWatchedAchievementItem = $this->lessonsAchievements->filter(function ($item) use ($lessonsWatchedCount) {
            return $item['count'] === $lessonsWatchedCount;
        });
        $unlockedAchievementItems = $unlockedCommentsWrittenAchievementItem->merge($unlockedLessonsWatchedAchievementItem)->pluck('message');

        return $unlockedAchievementItems->filter()->first();
    }

    /**
     * @param int $commentsWrittenCount
     * @param int int $lessonsWatchedCount
     * @return array
     */
    public function getUnlockedAchievements(int $commentsWrittenCount, int $lessonsWatchedCount): array
    {
        $unlockedCommentsWrittenAchievementItems = $this->commentsAchievements->filter(function ($item) use ($commentsWrittenCount) {
            return $item['count'] <= $commentsWrittenCount;
        });
        $unlockedLessonsWatchedAchievementItems = $this->lessonsAchievements->filter(function ($item) use ($lessonsWatchedCount) {
            return $item['count'] <= $lessonsWatchedCount;
        });
        $unlockedAchievements = $unlockedCommentsWrittenAchievementItems->merge($unlockedLessonsWatchedAchievementItems)->pluck('message');

        return $unlockedAchievements->toArray();
    }

    /**
     * @param User $user
     * @return string|null
     */
    public function getUnlockedBadge(int $achievementsCount): ?string
    {
        $unlockedBadgeItem = $this->badgesAchievements->last(function ($item) use ($achievementsCount) {
            return $item['achievements_count'] === $achievementsCount;
        });

        return $unlockedBadgeItem['message'] ?? null;
    }
}
