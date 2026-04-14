<?php

namespace Database\Factories;

use App\Models\log_klasifikasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<log_klasifikasi>
 */
class log_klasifikasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lokasi'=>$this->faker->city(),
            'keyakinan_model'=>$this->faker->randomFloat(2, 0.70, 0.99),
            'hasil_label'=>$this->faker->randomElement(['Healthy', 'BrownSpot', 'Hispa', 'LeafBlast']),
            'created_at' => $this->faker->dateTimeBetween('-3 week', 'now')
        ];
    }
}
