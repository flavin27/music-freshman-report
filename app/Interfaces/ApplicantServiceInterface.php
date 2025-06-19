<?php

namespace App\Interfaces;

interface ApplicantServiceInterface
{
    public static function insertFirstPhase(array $data, int $semester): void;

    public static function insertSecondPhase(array $data, int $semester): void;

    public static function extractInstrument(string $fullCourseName): string;
}
