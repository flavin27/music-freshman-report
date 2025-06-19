<?php

namespace App\Providers;

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
            ]);
        });
    }

    public function boot(): void
    {
        //
    }
}
