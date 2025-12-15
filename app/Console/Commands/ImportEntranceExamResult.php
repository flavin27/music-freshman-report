<?php

namespace App\Console\Commands;

class ImportEntranceExamResult extends BaseCommand
{
    protected $signature = 'app:import {json}';
    protected $description = 'Import data from provided JSON file.';

    /**
     * @throws \Exception
     */
    public function handle(): int
    {
        $json = $this->argument('json');
        $data = json_decode(file_get_contents($json), true);

        foreach ($data as $item) {
            $url = $item['url'];

            $fileName = $this->getFileNameFromUrl($url);
            $path = $this->downloadRawData($url, $fileName);
            $raw = $this->extractText($path);


            $year = $this->extractYearFromUrl($url);
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

