<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\{
    BaseRepository,
    BaseRepositoryInterface,
    CommentRepository,
    CommentRepositoryInterface,
    LessonRepository,
    LessonRepositoryInterface,
    UserRepository,
    UserRepositoryInterface
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
        LessonRepositoryInterface::class => LessonRepository::class,
        UserRepositoryInterface::class => UserRepository::class
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
