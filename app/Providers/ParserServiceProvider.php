<?php

namespace App\Providers;

use App\Interfaces\ApplicantParserInterface;
use App\Parsers\Factories\ApplicantParserFactory;
use Illuminate\Support\ServiceProvider;

class ParserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ApplicantParserInterface::class, function () {
            return new ApplicantParserFactory([
                2025 => \App\Parsers\ApplicantParser2025::class,
//                2024 => \App\Parsers\ApplicantParser2024::class,
//                2023 => \App\Parsers\ApplicantParser2023::class,
//                2022 => \App\Parsers\ApplicantParser2022::class,
//                2021 => \App\Parsers\ApplicantParser2021::class,
//                2020 => \App\Parsers\ApplicantParser2020::class,
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
