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
        $kab = $this->faker->randomElement(['Jember', 'Situbondo', 'Lumajang', 'Bondowoso', 'Banyuwangi']);
        return [
            'lokasi'=>[
                'provinsi' =>'Jawa Timur',
                'kabupaten'=>$kab,
                'kecamatan'=>$this->faker->randomElement(config('konstanta.daerah')[$kab]),
                'koordinat'=> [
                    $this->faker->randomFloat(3,  -8.23, -7.73),
                    $this->faker->randomFloat(3, 113.12, 114.36)
                    ]
                ],
            'keyakinan_model'=>$this->faker->randomFloat(2, 0.40, 0.99),
            'hasil_label'=>$this->faker->randomElement(['Healthy', 'Bacterial Leaf Blight', 'BrownSpot', 'Leaf Scald', 'Leaf Blast', 'Narrow Brown Spot']),
            'created_at' => $this->faker->dateTimeBetween('-104 week', 'now')
        ];
    }
}
