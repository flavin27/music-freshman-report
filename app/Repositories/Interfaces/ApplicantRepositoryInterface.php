<?php

namespace App\Repositories\Interfaces;

use App\DTO\ApplicantDTO;
use App\Models\Applicant;

interface ApplicantRepositoryInterface
{
    public function store(ApplicantDTO $applicant): Applicant;

}
