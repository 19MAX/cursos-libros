<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'ci' => '0000000000',
            'name' => 'ADMIN',
            'surname' => 'PRUEBA',
            'username' => 'admin',
            'email' => 'admin@prueba.com',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);
    }
}
