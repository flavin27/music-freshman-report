<?php

namespace App\Interfaces;

interface ApplicantParserInterface
{
    public function parse(array $raw): array;
}
