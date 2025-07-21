<?php

namespace Database\Factories;

use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Applicant>
 */
class ApplicantFactory extends Factory
{

    protected $model = Applicant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'instrument' => $this->faker->randomElement(['Violão', 'Guitarra', 'Baixo', 'Bateria', 'Teclado', 'Saxofone']),
            'degree_type' => $this->faker->randomElement(['Bacharelado', 'Licenciatura']),
            'shift' => $this->faker->randomElement(['Integral', 'Noturno']),
            'campus' => 'Escola de Música',
            'semester' => $this->faker->numberBetween(2023, 2025),
            'is_approved' => $this->faker->boolean(),
        ];
    }
}
