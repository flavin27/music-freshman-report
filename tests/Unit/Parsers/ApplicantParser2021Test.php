<?php

namespace Tests\Unit\Parsers;

use App\DTO\ApplicantDTO;
use App\Parsers\ApplicantParser2021;
use App\Parsers\Factories\ApplicantParserFactory;
use PHPUnit\Framework\TestCase;

class ApplicantParser2021Test extends TestCase
{
    protected ApplicantParserFactory $parserFactory;

    public function setUp(): void
    {
        $this->parserFactory = new ApplicantParserFactory([
            2021 => ApplicantParser2021::class,
        ]);
    }



    public function test_parse_returns_correct_dto_array()
    {
        $parser = $this->parserFactory->make(2021);

        $raw = [
            "Música / Harpa - Bacharelado                      42       Cléo Rodrigues Valentim                                           Apto",
            "Música / Piano - Bacharelado                     131       Ana Luiza Santos Morais                                           Não Apto",
        ];

        $result = $parser->parse($raw);

        $this->assertCount(2, $result);

        $this->assertInstanceOf(ApplicantDTO::class, $result[0]);
        $this->assertInstanceOf(ApplicantDTO::class, $result[1]);

        $this->assertEquals('Cléo Rodrigues Valentim', $result[0]->name);
        $this->assertEquals('Harpa', $result[0]->instrument);
        $this->assertEquals('Bacharelado', $result[0]->degreeType);
        $this->assertEquals('Integral', $result[0]->shift);
        $this->assertEquals('Escola de Música', $result[0]->campus);
        $this->assertEquals(2021, $result[0]->semester);
        $this->assertTrue($result[0]->is_approved);

        $this->assertEquals('Ana Luiza Santos Morais', $result[1]->name);
        $this->assertEquals('Piano', $result[1]->instrument);
        $this->assertFalse($result[1]->is_approved);
    }

    public function test_parser_ignore_invalid_lines() {
        $parser = $this->parserFactory->make(2021);

        $raw = [
            "Música / Harpa - Bacharelado                      42       Cléo Rodrigues Valentim                                           Apto",
            "Ana Luiza Santos Morais                                           Apto",
        ];

        $result = $parser->parse($raw);

        $this->assertCount(1, $result);

        $this->assertInstanceOf(ApplicantDTO::class, $result[0]);
    }
}
