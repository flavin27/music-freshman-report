<?php

namespace App\Parsers\Factories;

use App\Interfaces\ApplicantParserInterface;
use InvalidArgumentException;

class ApplicantParserFactory
{
    protected array $parsers;
    public function __construct(array $parsers)
    {
        $this->parsers = $parsers;
    }

    public function make(int $year): ApplicantParserInterface
    {
        if (!isset($this->parsers[$year])) {
            throw new InvalidArgumentException("Nenhum parser registrado para o ano {$year}.");
        }

        return app($this->parsers[$year]);
    }
}
