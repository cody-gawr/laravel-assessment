<?php

namespace App\Repositories;

use App\Models\Lesson;

class LessonRepository extends BaseRepository implements LessonRepositoryInterface
{
    /**
     * LessonRepository constructor.
     *
     * @param Lesson $model
     */
    public function __construct(Lesson $model)
    {
        parent::__construct($model);
    }
}
