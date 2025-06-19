<?php

namespace App\DTO;

readonly class ApplicantDTO
{
    public function __construct(
        public string $name,
        public string $instrument,
        public int $semester,
        public string $degreeType,
        public string $shift,
        public string $campus,
        public bool $is_approved,
    ) {
    }
}
