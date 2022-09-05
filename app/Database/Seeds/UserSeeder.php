<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\ModelUser;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user_object = new Modeluser();

        $user_object->insertBatch([
            [
                "nama_lengkap" => "Topan Nurpana",
                "username" => "topan",
                "password" => password_hash("12345678", PASSWORD_DEFAULT),
                "photo" => "default.jpg",
                "role" => "1",
            ]
        ]);
    }
}
