<?php

namespace App\Interfaces;

use App\DTO\ApplicantDTO;

interface ApplicantParserInterface
{
    /**
     * Parses the raw data and returns an array of ApplicantDTO objects.
     *
     * @param array $raw The raw data to parse.
     * @return ApplicantDTO[] An array of ApplicantDTO objects.
     */
    public function parse(array $raw): array;
}
