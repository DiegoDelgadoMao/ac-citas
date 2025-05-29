<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['id_rol' => 1, 'nombre_rol' => 'Admin'],
            ['id_rol' => 2, 'nombre_rol' => 'Técnico'],
            ['id_rol' => 3, 'nombre_rol' => 'Cliente'],
        ];
        $this->db->table('roles')->insertBatch($data);
    }
}
