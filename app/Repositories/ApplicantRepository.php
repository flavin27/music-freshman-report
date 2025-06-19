<?php

namespace App\Repositories;

use App\DTO\ApplicantDTO;
use App\Models\Applicant;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;

class ApplicantRepository implements ApplicantRepositoryInterface
{

    public function store(ApplicantDTO $applicant): Applicant
    {
        return Applicant::updateOrCreate(
            [
                'name' => $applicant->name,
                'instrument' => $applicant->instrument,
                'semester' => $applicant->semester,
                'degree_type' => $applicant->degreeType,
                'shift' => $applicant->shift,
                'campus' => $applicant->campus,
            ],
            [
                'is_approved' => $applicant->is_approved
            ]
        );
    }
}
