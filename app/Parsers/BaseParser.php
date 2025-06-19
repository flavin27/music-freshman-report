<?php

namespace App\Parsers;

use App\DTO\ApplicantDTO;
use App\Interfaces\ApplicantParserInterface;

abstract class BaseParser implements ApplicantParserInterface
{
    /**
     * Parses the raw data and returns an array of ApplicantDTO objects.
     *
     * @param array $raw The raw data to parse.
     * @return ApplicantDTO[] An array of ApplicantDTO objects.
     */
    abstract public function parse(array $raw): array;

    protected function extractInstrument(string $fullCourseName): string
    {
        if (preg_match('/\/\s*(.*?)\s* -/', $fullCourseName, $matches)) {
            return trim($matches[1]);
        }

        return trim(preg_replace('/^(Música\s*\/\s*)?/', '', $fullCourseName));
    }

    protected function isApto(string $value): bool
    {
        return strtolower(trim($value)) === 'apto';
    }


}
