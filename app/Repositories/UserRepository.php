<?php

namespace App\Repositories;

use App\Models\{
    Lesson,
    User
};

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $body
     * @return bool
     */
    public function commented(string $body): bool
    {
        return false;
    }

    /**
     * @param Lesson $lesson
     * @return bool
     */
    public function watched(Lesson $lesson, User $user): array
    {
        return $user->lessons()->sync($lesson, false);
    }
}
