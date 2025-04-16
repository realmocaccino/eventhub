<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\EventRepositoryInterface::class,
            \App\Repositories\EloquentEventRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\EventRegistrationRepositoryInterface::class,
            \App\Repositories\EloquentEventRegistrationRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\UserRepositoryInterface::class,
            \App\Repositories\EloquentUserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
