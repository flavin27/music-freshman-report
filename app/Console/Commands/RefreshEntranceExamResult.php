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
    protected $signature = 'app:refresh {year?}';

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

        $yearArg = $this->argument('year');

        $files = Storage::files('public/pdfs');

        if (empty($files)) {
            $this->error('No files found in the public/pdfs directory.');
            return 1;
        }

        foreach ($files as $file) {
            $year = $this->extractYearFromUrl($file);
            if (!$yearArg) {
                $this->info("Processing file: $file");

                $path = Storage::path($file);

                $raw = $this->extractText($path);

                $parser = $this->parserFactory->make($year);
                $dtos = $parser->parse($raw);

                foreach ($dtos as $dto) {
                    $this->applicantRepository->store($dto);
                }
            } else {
                if ($yearArg == $year) {
                    $this->info("Processing file: $file");

                    $path = Storage::path($file);

                    $raw = $this->extractText($path);

                    $parser = $this->parserFactory->make($year);
                    $dtos = $parser->parse($raw);

                    foreach ($dtos as $dto) {
                        $this->applicantRepository->store($dto);
                    }
                }
            }

        }
        $this->info("Import finished.");
        return 0;
    }
}
