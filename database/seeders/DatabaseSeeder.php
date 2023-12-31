<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Jadwal;
use App\Models\RekamTerapi;
use App\Models\Terapis;
use Illuminate\Database\Seeder;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // RekamTerapi::factory(10)->create();
        // Jadwal::factory(10)->create();
        Terapis::create([
            'id_terapis' => IdGenerator::generate(['table' => 'terapis', 'field' => 'id_terapis', 'length' => 6, 'prefix' => 'KPL']),
            'username' => 'agus',
            'nama' => 'H. Agus Hidayatulloh, S.T, M.T',
            'alamat' => 'Kekalik, Mataram',
            'no_telp' => '08746453674',
            'jenis_kelamin' => 'Laki-Laki',
            'agama' => 'Islam',
            'password' => bcrypt('123')
        ]);
    }
}
