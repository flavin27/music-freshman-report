<?php

namespace App\Providers;

use App\Repositories\ApplicantRepository;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ApplicantRepositoryInterface::class,
            ApplicantRepository::class
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
