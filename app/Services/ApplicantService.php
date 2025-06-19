<?php

namespace App\Services;
use App\Models\Applicant;

class ApplicantService
{
    /**
     * Retrieves the list of applicants.
     *
     * @return Applicant[] The list of applicants.
     */
    public function getApplicants(): array
    {
        return Applicant::all()->toArray();
    }

    /**
     * Retrieves a specific applicant by ID.
     *
     * @param int $id The ID of the applicant.
     * @return Applicant|null The applicant if found, null otherwise.
     */
    public function getApplicantById(int $id): ?Applicant
    {
        return Applicant::find($id);
    }
}

?>
