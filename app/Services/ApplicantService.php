<?php

namespace App\Services;
use App\Models\Applicant;

class ApplicantService
{
    public static function insertFirstPhase(array $data): void
    {
        $instrument = self::extractInstrument($data[0]);
        $name = trim($data[4]);
        $degreeType = $data[1];
        $shift = $data[2];
        $campus = $data[3];
        $approvedFirstPhase = $data[5] === 'Apto' ? true : false;

        Applicant::create([
            'name' => $name,
            'instrument' => $instrument,
            'semester' => $semester,
            'degree_type' => $degreeType,
            'shift' => $shift,
            'campus' => $campus,
            'approved_first_phase' => $approvedFirstPhase,
        ]);

    }

    public static function insertSecondPhase(array $data, int $semester): void
    {
        $instrument = self::extractInstrument($data[0]);
        $name = trim($data[4]);
        $degreeType = $data[1];
        $shift = $data[2];
        $campus = $data[3];
        $approvedSecondPhase = $data[5] === 'Apto' ? true : false;

        Applicant::updateOrCreate(
            ['name' => $name,
            'semester' => $semester,
            'instrument' => $instrument,
            'degree_type' => $degreeType,
            'shift' => $shift,
            'campus' => $campus],
            [
                'approved_second_phase' => $approvedSecondPhase
            ]
        );
    }

}

?>
