<?php

namespace Tests\Unit\Parsers;

use App\DTO\ApplicantDTO;
use App\Parsers\ApplicantParser2016;
use App\Parsers\Factories\ApplicantParserFactory;
use PHPUnit\Framework\TestCase;

class ApplicantParser2016Test extends TestCase
{
    protected ApplicantParserFactory $parserFactory;

    public function setUp(): void
    {
        $this->parserFactory = new ApplicantParserFactory([
            2016 => ApplicantParser2016::class,
        ]);
    }



    public function test_parse_returns_correct_dto_array()
    {
        $parser = $this->parserFactory->make(2016);

        $raw = [
            "SILVANA CRISTINA ALVES DE SOUZA                        1020      Música / Violoncelo - Bacharelado                          Apto",
            "MARIANA CAMPELLO DO RÊGO VALENÇA                       847       Música / Violoncelo - Bacharelado                         Faltoso",
        ];

        $result = $parser->parse($raw);

        $this->assertCount(2, $result);

        $this->assertInstanceOf(ApplicantDTO::class, $result[0]);
        $this->assertInstanceOf(ApplicantDTO::class, $result[1]);

        $this->assertEquals('SILVANA CRISTINA ALVES DE SOUZA', $result[0]->name);
        $this->assertEquals('Violoncelo', $result[0]->instrument);
        $this->assertEquals('Bacharelado', $result[0]->degreeType);
        $this->assertEquals('Integral', $result[0]->shift);
        $this->assertEquals('Escola de Música', $result[0]->campus);
        $this->assertEquals(2016, $result[0]->semester);
        $this->assertTrue($result[0]->is_approved);

        $this->assertEquals('MARIANA CAMPELLO DO RÊGO VALENÇA', $result[1]->name);
        $this->assertEquals('Violoncelo', $result[1]->instrument);
        $this->assertFalse($result[1]->is_approved);
    }

    public function test_parser_ignore_invalid_lines() {
        $parser = $this->parserFactory->make(2016);

        $raw = [
            "ARTHUR DE SOUSA FIGUEIREDO                     537       Música / Flauta - Bacharelado                              Apto",
            "Ana Luiza Santos Morais                                           Apto",
        ];

        $result = $parser->parse($raw);

        $this->assertCount(1, $result);

        $this->assertInstanceOf(ApplicantDTO::class, $result[0]);
    }
}
