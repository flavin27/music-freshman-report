<?php

namespace App\Providers;

use App\Parsers\ApplicantParser2016;
use App\Parsers\ApplicantParser2021;
use Illuminate\Support\ServiceProvider;
use App\Parsers\Factories\ApplicantParserFactory;
use App\Parsers\ApplicantParser2025;
// use App\Parsers\ApplicantParser2024; // Uncomment if you have a separate parser for 2024

class ParserServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Matching each year with its respective parser class
        $this->app->singleton(ApplicantParserFactory::class, function () {
            return new ApplicantParserFactory([
                2025 => ApplicantParser2025::class,
                2024 => ApplicantParser2025::class,
                2023 => ApplicantParser2025::class,
                2022 => ApplicantParser2021::class,
                2021 => ApplicantParser2021::class,
                2020 => ApplicantParser2016::class,
                2019 => ApplicantParser2016::class,
                2018 => ApplicantParser2016::class,
                2017 => ApplicantParser2016::class,
                2016 => ApplicantParser2016::class,
            ]);
        });
    }

    public function boot(): void
    {
        //
    }
}
