<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportEntranceExamResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = $this->argument('url');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->error('Invalid URL provided.');
            return 1;
        }

        $this->info("Processing URL: {$url}");

        $this->info('Import completed successfully.');
        return 0;
    }
}
