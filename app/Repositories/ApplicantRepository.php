<?php

namespace App\Repositories;

use App\DTO\ApplicantDTO;
use App\Models\Applicant;
use App\Repositories\Interfaces\ApplicantRepositoryInterface;

class ApplicantRepository implements ApplicantRepositoryInterface
{

    public function store(ApplicantDTO $applicant): Applicant
    {
		$a = Applicant::where([
			'name' => $applicant->name,
			'instrument' => $applicant->instrument,
			'semester' => $applicant->semester,
			'degree_type' => $applicant->degreeType,
			'shift' => $applicant->shift,
			'campus' => $applicant->campus,
		])->first();
		
		if ($a) {
			if ($applicant->is_approved && !$a->is_approved) {
				$a->is_approved = true;
				$a->save();
			}
			return $a;
		}
		
		return Applicant::create([
			'name' => $applicant->name,
			'instrument' => $applicant->instrument,
			'semester' => $applicant->semester,
			'degree_type' => $applicant->degreeType,
			'shift' => $applicant->shift,
			'campus' => $applicant->campus,
			'is_approved' => $applicant->is_approved,
		]);
		
		
    }
}
