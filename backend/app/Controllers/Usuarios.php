<?php namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\RoleModel;

class Usuarios extends BaseController
{
    protected $usrModel;
    protected $roleModel;

    public function __construct()
    {
        $this->usrModel  = new UsuarioModel();
        $this->roleModel = new RoleModel();
        helper(['form','url']);
    }

    /** Lista */
    public function index()
    {
        $usuarios = $this->usrModel
            ->select('usuarios.*, roles.nombre_rol')
            ->join('roles','roles.id_rol = usuarios.id_rol')
            ->findAll();

        return view('usuarios/index', [
            'title'=>'Usuarios',
            'usuarios'=>$usuarios,
            'msg'=>session('msg')
        ]);
    }

    /** Form nuevo */
    public function create()
    {
        return view('usuarios/form', [
            'title'=>'Nuevo Usuario',
            'roles'=>$this->roleModel->findAll(),
            'action'=>base_url('/usuarios/store'),
            'validation'=>\Config\Services::validation(),
        ]);
    }

    public function store()
    {
        $rules = [
            'nombre_completo' => 'required|min_length[3]|max_length[100]',
            'email'           => 'required|valid_email|is_unique[usuarios.email]',
            'password'        => 'required|min_length[6]',
            'id_rol'          => 'required|is_natural_no_zero'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->usrModel->save([
            'nombre_completo'=>$this->request->getPost('nombre_completo'),
            'telefono'       =>$this->request->getPost('telefono'),
            'email'          =>$this->request->getPost('email'),
            'password'       =>$this->request->getPost('password'),
            'id_rol'         =>$this->request->getPost('id_rol'),
        ]);

        return redirect()->to('/usuarios')->with('msg','Usuario creado');
    }

    /** Form editar */
    public function edit($id)
    {
        $user = $this->usrModel->find($id);

        return view('usuarios/form', [
            'title'=>'Editar Usuario',
            'usuario'=>$user,
            'roles'=>$this->roleModel->findAll(),
            'action'=>base_url('/usuarios/update/'.$id),
            'validation'=>\Config\Services::validation(),
        ]);
    }

    public function update($id)
    {
        $rules = [
            'nombre_completo' => 'required|min_length[3]|max_length[100]',
            'email'           => "required|valid_email|is_unique[usuarios.email,id_usuario,$id]",
            'id_rol'          => 'required|is_natural_no_zero'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $datos = [
            'nombre_completo'=>$this->request->getPost('nombre_completo'),
            'telefono'       =>$this->request->getPost('telefono'),
            'email'          =>$this->request->getPost('email'),
            'id_rol'         =>$this->request->getPost('id_rol'),
        ];

        if ($pass = $this->request->getPost('password')) {
            $datos['password'] = $pass;   // será hasheado por hook
        }

        $this->usrModel->update($id, $datos);
        return redirect()->to('/usuarios')->with('msg','Usuario actualizado');
    }

    public function delete($id)
    {
        $this->usrModel->delete($id);
        return redirect()->to('/usuarios')->with('msg','Usuario eliminado');
    }
}
