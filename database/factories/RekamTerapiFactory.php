<?php

namespace Database\Factories;

use App\Models\Terapis;
use App\Models\SubRekamMedis;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamTerapi>
 */
class RekamTerapiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $keluhan = [
            "Pusing dan sakit kepala yang parah",
            "Nyeri perut dan mual",
            "Batuk kering dan tenggorokan terasa sakit",
            "Demam tinggi dan menggigil",
            "Sesak napas dan sulit bernafas",
            "Muntah-muntah dan diare",
            "Sakit tenggorokan dan sulit menelan",
            "Nyeri sendi dan kemerahan pada kulit",
            "Rasa gatal dan mata berair",
            "Pingsan dan lemas",
            "Nyeri pinggang dan sering buang air kecil",
            "Sakit perut sebelah kanan bawah",
            "Demam tinggi dan sakit kepala hebat",
            "Mual dan penurunan berat badan",
            "Kelelahan dan pucat",
            "Nafsu makan menurun dan lemas",
            "Gangguan tidur dan perasaan cemas",
            "Nyeri otot dan sendi",
            "Mata berkunang-kunang dan mual",
            "Sakit kepala sebelah dan sensitif terhadap cahaya"
        ];
          
        return [
            'id_terapi' => $this->faker->numerify('T2309###'),
            'id_terapis' => Terapis::all()->random()->id_terapis,
            'id_sub' => SubRekamMedis::all()->random()->id_sub,
            'tanggal' => $this->faker->dateTimeBetween('2023-08-01', '2023-09-31'),
            'waktu' => $this->faker->time(),
            'keluhan' => $keluhan[rand(0,19)],
            'deteksi' => $this->faker->sentence(mt_rand(2, 3)),
            'tindakan' => $this->faker->sentence(mt_rand(2, 4)),
            'saran' => $this->faker->sentence(mt_rand(2, 4)),
            'pra_terapi' => $this->faker->sentence(mt_rand(2, 4)),
            'post_terapi' => $this->faker->sentence(mt_rand(2, 4)),
        ];
    }
}
