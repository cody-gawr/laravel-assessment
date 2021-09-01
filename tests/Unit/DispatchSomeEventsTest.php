<?php

namespace Tests\Unit;

use App\Events\{
    AchievementUnlocked,
    BadgeUnlocked,
    CommentWritten,
    LessonWatched
};
use App\Models\{
    Comment,
    Lesson,
    User
};
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DispatchSomeEventsTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testDispatchSomeEvents()
    {
        Event::fake([
            AchievementUnlocked::class,
            BadgeUnlocked::class
        ]);
        $userForSomeEvents = User::factory()->create([
            'name' => 'User SomeEvents'
        ]);
        Comment::factory()
            ->count(10)
            ->for($userForSomeEvents)
            ->create();
        Lesson::factory()
            ->count(25)
            ->hasAttached($userForSomeEvents, ['watched' => true])
            ->create();

        event(new CommentWritten($userForSomeEvents->comments->first()));
        event(new LessonWatched($userForSomeEvents->lessons->first(), $userForSomeEvents));

        Event::assertDispatched(AchievementUnlocked::class);
        Event::assertDispatched(BadgeUnlocked::class);
    }
}
