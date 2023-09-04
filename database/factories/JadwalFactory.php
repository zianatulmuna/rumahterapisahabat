<?php

namespace Database\Factories;

use App\Models\Terapis;
use App\Models\SubRekamMedis;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jadwal>
 */
class JadwalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sub = SubRekamMedis::all()->random();
        $id_terapis = Terapis::all()->random()->id_terapis;

        return [
            'id_jadwal' => $this->faker->unique()->numerify('JDW2309###'),
            'id_sub' => $sub->id_sub,
            'id_pasien' => $sub->rekamMedis->id_pasien,
            'id_terapis' => $id_terapis,
            'tanggal' => '2023-09-03',
            'waktu' => $this->faker->time(),
        ];
    }
}
