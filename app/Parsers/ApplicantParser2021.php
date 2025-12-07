<?php

namespace App\Parsers;

use App\DTO\ApplicantDTO;
use App\Enums\DegreeType;
use App\Enums\Shift;

class ApplicantParser2021 extends BaseParser
{

    protected int $semester;

    public function __construct(int $semester)
    {
        $this->semester = $semester;
    }


    public function parse(array $raw): array
    {
        $applicantList = [];

        foreach ($raw as $item ){
            $rawApplicant = preg_split('/\s{2,}/', $item);
            if (count($rawApplicant) > 3 && !empty($rawApplicant[0]) && $rawApplicant[0] != 'Opção') {



                $applicant = new ApplicantDTO(
                    name: trim($rawApplicant[2]),
                    instrument: $this->extractInstrument($rawApplicant[0]),
                    semester: $this->semester,
                    degreeType: DegreeType::Barcharelado->value,
                    shift: Shift::Integral->value,
                    campus: "Escola de Música",
                    is_approved: $this->isApto($rawApplicant[3] ?? '')
                );
                $applicantList[] = $applicant;
            }
        }
        return $applicantList;
    }
}
