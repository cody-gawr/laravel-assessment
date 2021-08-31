<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\{
    BaseRepository,
    BaseRepositoryInterface,
    CommentRepository,
    CommentRepositoryInterface,
    LessonRepository,
    LessonRepositoryInterface
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        BaseRepositoryInterface::class => BaseRepository::class,
        CommentRepositoryInterface::class => CommentRepository::class,
        LessonRepositoryInterface::class => LessonRepository::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
