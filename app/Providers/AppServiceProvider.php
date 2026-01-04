<?php

namespace App\Providers;

use App\Repositories\ProjectRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            ProjectRepositoryInterface::class,
            ProjectRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
