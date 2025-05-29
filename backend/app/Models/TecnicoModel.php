<?php

namespace App\Models;

use CodeIgniter\Model;

class TecnicoModel extends Model
{
    protected $table         = 'tecnicos';
    protected $primaryKey    = 'id_tecnico';
    protected $allowedFields = ['id_usuario', 'especialidad'];
    protected $returnType    = 'array';
}
