<?php

namespace Tests\Feature;

use App\Models\Applicant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplicantControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_returns_view_with_data()
    {
        Applicant::factory()->create([
            'instrument' => 'Saxofone',
            'is_approved' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('applicants.index');

        $response->assertSee('Saxofone');
        $response->assertSee('1');
        $response->assertSee('100.00');

    }

    public function test_show_returns_view_with_instrument_data()
    {
        $instrument = 'Flauta';
        Applicant::factory()->create([
            'instrument' => $instrument,
            'semester' => 2024,
            'is_approved' => true,
        ]);

        $response = $this->get("/details/{$instrument}");

        $response->assertStatus(200);
        $response->assertViewIs('applicants.details');

        $response->assertSee($instrument);
        $response->assertSee('2024');
        $response->assertSee('1');
        $response->assertSee('100.00');
    }
}
