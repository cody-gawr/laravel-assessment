<?php

namespace App\Repositories;

use App\Models\Lesson;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function commented(string $body): bool;
    public function watched(Lesson $lesson): bool;
}
