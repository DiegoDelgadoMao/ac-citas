<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiciosSeeder extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('servicios');

        $data = [
            [
                'id_servicio'  => 1,
                'tipo_servicio'=> 'MANTENIMIENTO PREVENTIVO',
                'descripcion'  => 'Aseo general, revisión de filtros y niveles de refrigerante.'
            ],
            [
                'id_servicio'  => 2,
                'tipo_servicio'=> 'MANTENIMIENTO CORRECTIVO',
                'descripcion'  => 'Reparación de fallas, reemplazo de componentes defectuosos.'
            ],
            [
                'id_servicio'  => 3,
                'tipo_servicio'=> 'INSTALACION',
                'descripcion'  => 'Montaje completo y puesta en marcha del equipo de aire acondicionado.'
            ],
        ];

        foreach ($data as $row) {
            // Evita insertar duplicados
            $exists = $builder
                ->where('id_servicio', $row['id_servicio'])
                ->countAllResults();

            if (! $exists) {
                $builder->insert($row);
            }
        }
    }
}
