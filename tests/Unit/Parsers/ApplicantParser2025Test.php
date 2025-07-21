<?php

namespace Tests\Unit\Parsers;

use App\DTO\ApplicantDTO;
use App\Parsers\ApplicantParser2025;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class ApplicantParser2025Test extends TestCase
{

    public function test_parse_returns_correct_dto_array()
    {
        $parser = new ApplicantParser2025(2025);

        $raw = [
            "Música / Saxofone - Bacharelado               Bacharelado      Integral       Escola de Música   Misael Dias Silveira     Apto",
            "Música / Trompete - Bacharelado               Bacharelado      Integral       Escola de Música   Tiago Vieira do Nascimento     Não Apto",
        ];

        $result = $parser->parse($raw);

        $this->assertCount(2, $result);

        $this->assertInstanceOf(ApplicantDTO::class, $result[0]);
        $this->assertInstanceOf(ApplicantDTO::class, $result[1]);

        $this->assertEquals('Misael Dias Silveira', $result[0]->name);
        $this->assertEquals('Saxofone', $result[0]->instrument);
        $this->assertEquals('Bacharelado', $result[0]->degreeType);
        $this->assertEquals('Integral', $result[0]->shift);
        $this->assertEquals('Escola de Música', $result[0]->campus);
        $this->assertEquals(2025, $result[0]->semester);
        $this->assertTrue($result[0]->is_approved);

        $this->assertEquals('Tiago Vieira do Nascimento', $result[1]->name);
        $this->assertEquals('Trompete', $result[1]->instrument);
        $this->assertFalse($result[1]->is_approved);
    }

    public function test_parser_ignore_invalid_lines() {
        $parser = new ApplicantParser2025(2025);

        $raw = [
            "Música / Saxofone - Bacharelado               Bacharelado      Integral       Escola de Música   Misael Dias Silveira     Apto",
            "Tiago Vieira do Nascimento     Não Apto",
        ];

        $result = $parser->parse($raw);

        $this->assertCount(1, $result);

        $this->assertInstanceOf(ApplicantDTO::class, $result[0]);
    }
}
