<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events\LessonWatched;
use App\Models\User;
use App\Repositories\{
    CommentRepositoryInterface,
    LessonRepositoryInterface,
    UserRepositoryInterface,
};

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        return response()->json([
            'unlocked_achievements' => [],
            'next_available_achievements' => [],
            'current_badge' => '',
            'next_badge' => '',
            'remaing_to_unlock_next_badge' => 0
        ]);
    }

    public function test(CommentRepositoryInterface $commentRepository,
        LessonRepositoryInterface $lessonRepository, UserRepositoryInterface $userRepository) {
        $lesson = $lessonRepository->find(5);
        $user = $userRepository->find(1);
        LessonWatched::dispatch($lesson, $user);
    }
}
