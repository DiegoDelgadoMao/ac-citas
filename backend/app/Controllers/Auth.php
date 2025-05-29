<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Auth extends Controller
{

    /**
     * Login de usuario
     */
    public function login()
    {
        helper(['form', 'url']);
        // Siempre enviamos un objeto Validation a la vista
        $data['validation'] = \Config\Services::validation();

        if (isset($_POST["email"])) {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required'
            ];
            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                // Verificamos credenciales
                $model = new UsuarioModel();
                $user  = $model->where('email', $_POST['email'])->first();
                if ($user && password_verify($_POST['password'], $user['password'])) {
                    $session = session();
                    $session->set([
                        'user_id'    => $user['id_usuario'],
                        'user_name'  => $user['nombre_completo'],
                        'user_role'  => $user['id_rol'],
                        'isLoggedIn' => true,
                    ]);
                    // Redirección por rol
                    switch ($user['id_rol']) {
                        case 1:  // ADMIN
                            return redirect()->to('/admin/dashboard');
                        case 2:  // TÉCNICO
                            return redirect()->to('/tecnico/dashboard');
                        default: // CLIENTE
                            return redirect()->to('/dashboard');
                    }
                } else {
                    // Credenciales inválidas
                    $data['validation']->setError('password', 'Email o contraseña incorrectos');
                }
            }
        }

        // Cargamos la vista de login
        return view('login', $data);
    }


    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login')->with('msg', 'Sesión cerrada correctamente.');
    }
}
