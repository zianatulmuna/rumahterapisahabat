<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Admin; // Gantilah Admin dengan nama model yang sesuai

class AdminModelTest extends TestCase
{
    public function testUpdateAdmin()
    {
        $data = [
            'id_admin' => 'ADM005',
            'username' => 'agus2',
            'nama' => 'H. Agus Hidayatulloh, S.T, M.T',
            'alamat' => 'Kekalik, Mataram',
            'no_telp' => '08746453674',
            'jenis_kelamin' => 'Laki-Laki',
            'agama' => 'Islam',
            'password' => bcrypt('secret')
        ];

        $admin = Admin::create($data);

        $this->assertInstanceOf(Admin::class, $admin);

        $adminFromDatabase = Admin::find($admin->id_admin);

        foreach ($data as $field => $value) {
            $this->assertEquals($value, $admin->$field);
            $this->assertEquals($value, $adminFromDatabase->$field);
        }
    }

}
