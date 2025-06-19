<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Parsers\Factories\ApplicantParserFactory;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;
use Illuminate\Support\Facades\Storage;

abstract class BaseCommand extends Command
{
    protected ApplicantParserFactory $parserFactory;
    protected ApplicantRepositoryInterface $applicantRepository;

    public function __construct(ApplicantParserFactory $parserFactory, ApplicantRepositoryInterface $applicantRepository)
    {
        parent::__construct();
        $this->parserFactory = $parserFactory;
        $this->applicantRepository = $applicantRepository;
    }

    protected function extractYearFromUrl(string $url): int
    {
        preg_match('/(20\d{2})/', $url, $matches);
        return (int) ($matches[1] ?? throw new \Exception("Ano não encontrado na URL: $url"));
    }

    protected function getFileNameFromUrl(string $url): string
    {
        preg_match('/(20\d{2})/', $url, $match);
        $year = $match[1] ?? 'unknown';

        $lowerUrl = strtolower($url);

        return match (true) {
            str_contains($lowerUrl, 'inscritos') => "inscritos-{$year}.pdf",
            str_contains($lowerUrl, '2aetapa') => "result-{$year}-fase2.pdf",
            str_contains($lowerUrl, 'resultado') => "result-{$year}-fase1.pdf",
            default => "arquivo-{$year}.pdf"
        };
    }

    protected function downloadRawData(string $url, string $fileName): string
    {
        $this->info("Downloading: {$url}");

        $file = @file_get_contents($url);
        if (!$file) {
            throw new \Exception("Failed to download: {$url}");
        }

        Storage::put("public/pdfs/{$fileName}", $file);

        return Storage::path("public/pdfs/{$fileName}");
    }

    protected function extractText(string $path): array
    {
        $this->info("Extracting text from: {$path}");

        $output = shell_exec("pdftotext -layout {$path} -");

        return explode("\n", $output);
    }
}
