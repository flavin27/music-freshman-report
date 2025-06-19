<?php

namespace App\Parsers;


use App\DTO\ApplicantDTO;

class ApplicantParser2025 extends BaseParser
{

    private int $semester = 2025;

    /**
     * Parses the raw data and returns an array of ApplicantDTO objects.
     *
     * @param array $raw The raw data to parse.
     * @return ApplicantDTO[] An array of ApplicantDTO objects.
     */
    public function parse(array $raw): array
    {
        $applicantList = [];

        foreach ($raw as $item ){
            $rawApplicant = preg_split('/\s{2,}/', $item);

            if (count($rawApplicant) > 4 && !empty($rawApplicant[0])) {

                $applicant = new ApplicantDTO(
                    name: trim($rawApplicant[4]),
                    instrument: $this->extractInstrument($rawApplicant[0]),
                    semester: $this->semester,
                    degreeType: $rawApplicant[1],
                    shift: $rawApplicant[2],
                    campus: $rawApplicant[3],
                    is_approved: $this->isApto($rawApplicant[5])
                );
                $applicantList[] = $applicant;
            }
        }

        return $applicantList;
    }

}
