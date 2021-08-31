<?php

namespace App\Repositories;

use App\Models\Lesson;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function comments(string $body): bool;
    public function watched(Lesson $lesson): bool;
}
