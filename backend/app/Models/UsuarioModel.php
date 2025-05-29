<?php namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $returnType = 'array';
    protected $useTimestamps = false;

    // Campos permitidos para inserción/actualización masiva
    protected $allowedFields = ['nombre_completo','telefono','email','password','id_rol'];

    // Hooks para hashear la contraseña antes de guardar
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Hashea la contraseña antes de insert/update
     */
    protected function hashPassword(array $data)
    {
        if (! empty($data['data']['password'])) {
            $data['data']['password'] = password_hash(
                $data['data']['password'],
                PASSWORD_DEFAULT
            );
        }
        return $data;
    }
}
