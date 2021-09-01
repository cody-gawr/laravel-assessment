<?php

namespace App\Http\Controllers;

use App\Contracts\AchieveContract;

use App\Models\User;

class AchievementsController extends Controller
{
    public function index(User $user, AchieveContract $achieveContract)
    {
        return response()->json($achieveContract->getAchievements($user));
    }
}
