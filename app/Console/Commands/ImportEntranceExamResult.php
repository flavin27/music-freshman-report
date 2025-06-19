<?php

namespace App\Console\Commands;

use App\Models\Applicant;
use App\Parsers\Factories\ApplicantParserFactory;
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

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(ApplicantParserFactory $parserFactory)
    {
        parent::__construct();
        $this->parserFactory = $parserFactory;
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

            Storage::put($fileName, $file);

            $path = Storage::path($fileName);

            $this->info("Downloaded completed!");

            $this->info("Extracting data...");

            $output = shell_exec("pdftotext -layout {$path} -");

            $notas = explode("\n", $output);

            $ano = $this->extractYearFromUrl($url);

            $parser = $this->parserFactory->make($ano);

            $dados = $parser->parse($notas);


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

    private function downloadPdf(string $url, string $fileName): string
    {
        $this->info("Baixando PDF de: {$url}");

        $file = @file_get_contents($url);
        if (!$file) {
            throw new \Exception("Falha ao baixar o arquivo: {$url}");
        }

        Storage::put($fileName, $file);
        $this->info("Arquivo salvo em: {$fileName}");

        return Storage::path($fileName);
    }

}
