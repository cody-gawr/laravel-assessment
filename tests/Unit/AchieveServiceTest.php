<?php

namespace Tests\Unit;

use App\Contracts\AchieveContract;
use App\Models\{
    Comment,
    Lesson,
    User
};
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AchieveServiceTest extends TestCase
{
    /**
     * @var AchieveContract
     */
    private $achieveService;
    /**
     * @var User
     */
    private $beginner, $intermediate, $advanced, $master;

    public function setUp(): void
    {
        parent::setUp();

        $this->achieveService = app(AchieveContract::class);
        $this->beginner = User::factory()->create([
            'name' => 'beginner'
        ]);

        $this->intermediate = User::factory()->create([
            'name' => 'intermediate'
        ]);
        Comment::factory()
            ->count(3)
            ->for($this->intermediate)
            ->create();
        Lesson::factory()
            ->count(5)
            ->hasAttached($this->intermediate, ['watched' => true])
            ->create();

        $this->advanced = User::factory()->create([
            'name' => 'advanced'
        ]);
        Comment::factory()
            ->count(10)
            ->for($this->advanced)
            ->create();
        Lesson::factory()
            ->count(25)
            ->hasAttached($this->advanced, ['watched' => true])
            ->create();

        $this->master = User::factory()->create([
            'name' => 'master'
        ]);
        Comment::factory()
            ->count(20)
            ->for($this->master)
            ->create();
        Lesson::factory()
            ->count(50)
            ->hasAttached($this->master, ['watched' => true])
            ->create();
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_achievements_for_various_users(): void
    {
        $beginnerAchievement = $this->achieveService->getAchievements($this->beginner);
        $this->assertEquals([
            'unlocked_achievements' => [],
            'next_available_achievements' => [
                'First Comment Written',
                'First Lesson Watched',
            ],
            'current_badge' => 'Beginner',
            'next_badge' => 'Intermediate',
            'remaing_to_unlock_next_badge' => 4
        ], $beginnerAchievement, 'pass beginner achievement');

        $intermediateAchievement = $this->achieveService->getAchievements($this->intermediate);
        $this->assertEquals([
            'unlocked_achievements' => [
                'First Comment Written',
                '3 Comments Written',
                'First Lesson Watched',
                '5 Lessons Watched'
            ],
            'next_available_achievements' => [
                '5 Comments Written',
                '10 Lessons Watched'
            ],
            'current_badge' => 'Intermediate',
            'next_badge' => 'Advanced',
            'remaing_to_unlock_next_badge' => 4
        ], $intermediateAchievement, 'pass intermediate achievement');

        $advancedAchievement = $this->achieveService->getAchievements($this->advanced);
        $this->assertEquals([
            'unlocked_achievements' => [
                'First Comment Written',
                '3 Comments Written',
                '5 Comments Written',
                '10 Comments Written',
                'First Lesson Watched',
                '5 Lessons Watched',
                '10 Lessons Watched',
                '25 Lessons Watched'
            ],
            'next_available_achievements' => [
                '20 Comments Written',
                '50 Lessons Watched'
            ],
            'current_badge' => 'Advanced',
            'next_badge' => 'Master',
            'remaing_to_unlock_next_badge' => 2
        ], $advancedAchievement, 'pass advanced achievement');

        $masterAchievement = $this->achieveService->getAchievements($this->master);
        $this->assertEquals([
            'unlocked_achievements' => [
                'First Comment Written',
                '3 Comments Written',
                '5 Comments Written',
                '10 Comments Written',
                '20 Comments Written',
                'First Lesson Watched',
                '5 Lessons Watched',
                '10 Lessons Watched',
                '25 Lessons Watched',
                '50 Lessons Watched'
            ],
            'next_available_achievements' => [],
            'current_badge' => 'Master',
            'next_badge' => null,
            'remaing_to_unlock_next_badge' => 0
        ], $masterAchievement, 'pass master achievement');
    }
}
