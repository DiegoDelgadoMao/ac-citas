<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\TareaModel;   // ① Importamos el modelo
use CodeIgniter\Controller;

class Home extends BaseController
{
    public function index()
    {
        helper(['form', 'url']);
        $data['validation'] = \Config\Services::validation();
        return view('registro', $data);   // ② Usamos return view()
    }

    function registroUsuario()
    {
        helper(['form', 'url']);
        $data['validation'] = \Config\Services::validation();
        $rules = [
            'nombre_completo' => 'required|min_length[3]|max_length[100]',
            'telefono'        => 'permit_empty|regex_match[/^[0-9+\s\-]{7,20}$/]',
            'email'           => 'required|valid_email|is_unique[usuarios.email]',
            'password'        => 'required|min_length[6]',
            'pass_confirm'    => 'required|matches[password]'
        ];
        if (! $this->validate($rules)) {
            $data['validation'] = $this->validator;
        } else {
            $model = new UsuarioModel();
            $model->save([
                'nombre_completo' => $_POST['nombre_completo'],
                'telefono'        => $_POST['telefono'] ?? null,
                'email'           => $_POST['email'],
                'password'        => $_POST['password'],
                'id_rol'          => 3, // Cliente
            ]);
            return redirect()->to('/login');
        }
        // Y acá también usamos return, así el método termina aquí
        return view('registro', $data);
    }


    function paginaPrincipal()
    {
        $session = session();
        $userId = $session->get('user_id');
        // // Contar todas las tareas del usuario
        // $totalTareas = $model->where('usuario_id', $userId)->countAllResults();
        // // Tareas pendientes
        // $pendientes = $model->where(['usuario_id' => $userId, 'estado' => 'pendiente'])->countAllResults();
        // // Tareas completadas
        // $completadas = $model->where(['usuario_id' => $userId, 'estado' => 'hecha'])->countAllResults();
        // return view('dashboard', [
        //     'totalTareas' => $totalTareas,
        //     'pendientes'  => $pendientes,
        //     'completadas' => $completadas,
        // ]);
    }
}
