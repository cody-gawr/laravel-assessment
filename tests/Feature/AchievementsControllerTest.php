<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\{
    Comment,
    Lesson,
    User
};

class AchievementsControllerTest extends TestCase
{
    /**
     * @var User
     */
    private $anyUser;

    public function setUp(): void
    {
        parent::setUp();

        $this->anyUser = User::factory()->create([
            'name' => 'Any User'
        ]);
        Comment::factory()
            ->count(rand(0, 100))
            ->for($this->anyUser)
            ->create();
        Lesson::factory()
            ->count(rand(0, 100))
            ->hasAttached($this->anyUser, ['watched' => true])
            ->create();
    }

    public function testGetIndex(): void
    {
        $response = $this->get(sprintf('/users/%d/achievements', $this->anyUser->id));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'unlocked_achievements',
                'next_available_achievements',
                'current_badge',
                'next_badge',
                'remaing_to_unlock_next_badge'
            ]);
    }
}
