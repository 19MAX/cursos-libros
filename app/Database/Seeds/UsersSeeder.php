<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'ci' => '0000000000',
                'name' => 'ADMIN',
                'surname' => 'PRUEBA',
                'username' => 'admin',
                'email' => 'admin@prueba.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'ci' => '1111111111',
                'name' => 'DOCENTE',
                'surname' => 'PRUEBA',
                'username' => 'docente',
                'email' => 'docente@docente.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],

        ];

        $this->db->table('users')->insertBatch($data);
    }
}
