<?php

namespace App\Console\Commands;

use App\Models\Applicant;
use App\Parsers\Factories\ApplicantParserFactory;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportEntranceExamResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import {json}';

    private ApplicantParserFactory $parserFactory;

    private ApplicantRepositoryInterface $applicantRepository;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(ApplicantParserFactory $parserFactory, ApplicantRepositoryInterface $applicantRepository)
    {
        parent::__construct();
        $this->parserFactory = $parserFactory;
        $this->applicantRepository = $applicantRepository;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $json = $this->argument('json');

        $data = json_decode(file_get_contents($json), true);

        foreach($data as $item) {
            $url = $item['url'];

            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $this->error('Invalid URL provided.');
                return 1;
            }
            $this->info("Processing URL...");

            $file = file_get_contents($url);

            $fileName = "public/pdfs/" . $this->getFileNameFromUrl($url);

            $path = $this->downloadRawData($url, $fileName);

            $this->info("Extracting data...");

            $output = shell_exec("pdftotext -layout {$path} -");

            $rawData = explode("\n", $output);

            $year = $this->extractYearFromUrl($url);

            $parser = $this->parserFactory->make($year);

            $data = $parser->parse($rawData);

            $this->info("Saving data to the database...\n\n");

            foreach ($data as $applicantData) {
                $this->applicantRepository->store($applicantData);
                //$this->info("Applicant {$applicant->name} saved successfully.");
            }



        }


        $this->info('Import completed successfully.');
        return 0;
    }

    private function getFileNameFromUrl(string $url): string
    {
        preg_match('/(20\d{2})/', $url, $match);
        $year = $match[1] ?? 'unknown';

        $lowerUrl = strtolower($url);

        if (str_contains($lowerUrl, 'inscritos')) {
            return "inscritos-{$year}.pdf";
        }

        if (str_contains($lowerUrl, '2aetapa')) {
            return "result-{$year}-fase2.pdf";
        }

        if (str_contains($lowerUrl, 'resultado')) {
            return "result-{$year}-fase1.pdf";
        }

        return "arquivo-{$year}.pdf";
    }

    private function extractYearFromUrl(string $url): int
    {
        preg_match('/(20\d{2})/', $url, $matches);
        return (int) ($matches[1] ?? throw new \Exception("Ano não encontrado na URL: $url"));
    }

    private function downloadRawData(string $url, string $fileName): string
    {
        $this->info("Downloading data from: {$url}");

        $file = @file_get_contents($url);
        if (!$file) {
            throw new \Exception("Failed to download data from: {$url}");
        }

        Storage::put($fileName, $file);
        $this->info("File: {$fileName} saved  successfully");

        return Storage::path($fileName);
    }

}
