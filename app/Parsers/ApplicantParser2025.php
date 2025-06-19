<?php

namespace App\Parsers;


class ApplicantParser2025 extends BaseParser
{
    public function parse(array $raw): array
    {
        $dados = [];

        foreach ($raw as $nota ){
            $aluno = preg_split('/\s{2,}/', $nota);

            if (count($aluno) > 4 && !empty($aluno[0])) {
                $dados[] = $aluno;
            }
        }

        return $dados;
    }
}
