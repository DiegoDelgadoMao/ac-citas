<?php

namespace App\Models;

use CodeIgniter\Model;

class CitaModel extends Model
{
    protected $table         = 'citas';
    protected $primaryKey    = 'id_cita';
    protected $allowedFields = [
        'id_cliente', 'id_tecnico', 'id_servicio',
        'fecha', 'hora', 'estado'
    ];
    protected $returnType = 'array';
}
