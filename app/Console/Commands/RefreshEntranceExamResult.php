<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Storage;

class RefreshEntranceExamResult extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the entrance exam results from data stored';

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle(): int
    {
        $files = Storage::files('public/pdfs');

        if (empty($files)) {
            $this->error('No files found in the public/pdfs directory.');
            return 1;
        }

        foreach ($files as $file) {
            $this->info("Processing file: $file");

            $path = Storage::path($file);
            $year = $this->extractYearFromUrl($file);
            $raw = $this->extractText($path);

            $parser = $this->parserFactory->make($year);
            $dtos = $parser->parse($raw);

            foreach ($dtos as $dto) {
                $this->applicantRepository->store($dto);
            }

        }
        $this->info("Import finished.");
        return 0;
    }
}
