<?php

namespace App\Parsers;

use App\DTO\ApplicantDTO;
use App\Enums\Instruments;
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
            $instumento =  trim($matches[1]);
            if ($instumento === 'Instrum. de Percussão') {
                return Instruments::Percussao->value;
            }
            return $instumento;
        }

        return trim(preg_replace('/^(Música\s*\/\s*)?/', '', $fullCourseName));
    }

    protected function isApto(string $value): bool
    {
        return strtolower(trim($value)) === 'apto';
    }


}
