<?php

namespace App\Parsers;

use App\DTO\ApplicantDTO;
use App\Enums\DegreeType;
use App\Enums\Instruments;
use App\Enums\Shift;

class ApplicantParser2016 extends BaseParser
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
            // Only valid applicants have more than 3 fields and table header is ignored
            $instrument = $this->extractInstrument($rawApplicant[2] ?? '');
            if (count($rawApplicant) > 3 && !empty($rawApplicant[0]) && $rawApplicant[0] != 'Nome' && Instruments::tryFrom($instrument)) {

                $applicant = new ApplicantDTO(
                    name: trim($rawApplicant[0]),
                    instrument: $instrument,
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
