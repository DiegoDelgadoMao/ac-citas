<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    // $arguments contendrá el/los id_rol permitidos
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $role = session('user_role');

        if ($arguments && ! in_array($role, $arguments)) {
            return redirect()->to('/dashboard');      // acceso denegado
        }
    }

    public function after(RequestInterface $request,
                          ResponseInterface $response,
                          $arguments = null) {}
}
