<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportEntranceExamResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import {semester} {phase} {url}';

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
		$semester = $this->argument('semester');
		$phase = $this->argument('phase');

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            $this->error('Invalid URL provided.');
            return 1;
        }

        $this->info("Processing URL...");
		
		$file = file_get_contents($url);
		
		$fileName = "public/pdfs/result-{$semester}-{$phase}.pdf";
		
		Storage::put($fileName, $file);
		
		$path = Storage::path($fileName);
		
		$this->info("Downloaded completed!");
		
		$this->info("Extracting data...");
		
		$output = shell_exec("pdftotext -layout {$path} -");
		
		$notas = explode("\n", $output);
		
		$dados = [];

		foreach ($notas as $nota ){
			$aluno = preg_split('/\s{2,}/', $nota);

			if (count($aluno) > 4 && !empty($aluno[0])) {
				$dados[] = $aluno;
			}
		}
		
		print_r($dados);
		
        $this->info('Import completed successfully.');
        return 0;
    }
}
