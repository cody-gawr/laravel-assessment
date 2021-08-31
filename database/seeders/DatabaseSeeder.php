<?php

namespace Database\Seeders;

use App\Models\{
    Comment,
    Lesson,
    User
};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Lesson::factory()
            ->count(20)
            ->create();

        User::factory()
            ->has(Comment::factory()
                ->count(10)
            )
            ->create();

        User::factory()
            ->has(Lesson::factory()->count(3))
            ->create();
    }
}
