<?php

namespace App\Controllers;

use App\Models\TecnicoModel;
use App\Models\UsuarioModel;

class Tecnicos extends BaseController
{
    protected $tecModel;
    protected $usrModel;

    public function __construct()
    {
        $this->tecModel = new TecnicoModel();
        $this->usrModel = new UsuarioModel();
        helper(['form', 'url']);
    }

    /** Lista */
    public function index()
    {
        $tecnicos = $this->tecModel
            ->select('tecnicos.*, usuarios.nombre_completo, usuarios.email')
            ->join('usuarios', 'usuarios.id_usuario = tecnicos.id_usuario')
            ->findAll();

        return view('tecnicos/index', ['tecnicos' => $tecnicos, 'title' => 'Técnicos']);
    }

    /** Formulario nuevo */
    public function create()
    {
        // IDs de usuarios que ya son técnicos
        $idsTecnicos = $this->tecModel
            ->select('id_usuario')
            ->findColumn('id_usuario') ?: [0];   // ← agrega 0 si está vacío
        $disponibles = $this->usrModel
            ->select('id_usuario,nombre_completo,email')
            ->whereNotIn('id_usuario', $idsTecnicos)
            ->findAll();
        return view('tecnicos/form', [
            'title' => 'Nuevo Técnico',
            'usuarios' => $disponibles,
            'action' => base_url('/tecnicos/store'),
            'validation' => \Config\Services::validation(),
        ]);
    }

    /** Guardar */
    public function store()
    {
        $rules = [
            'id_usuario' => 'required|is_natural_no_zero|is_unique[tecnicos.id_usuario]',
            'especialidad' => 'required|min_length[3]|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->tecModel->insert([
            'id_usuario'  => $this->request->getPost('id_usuario'),
            'especialidad' => $this->request->getPost('especialidad'),
        ]);

        // Opcional: cambiar rol del usuario a 2 (TÉCNICO)
        $this->usrModel->update(
            $this->request->getPost('id_usuario'),
            ['id_rol' => 2]
        );

        return redirect()->to('/tecnicos')->with('msg', 'Técnico creado');
    }

    /** Formulario editar */
    public function edit($id)
    {
        $tec = $this->tecModel->find($id);
        return view('tecnicos/form', [
            'title' => 'Editar Técnico',
            'tecnico' => $tec,
            'action' => base_url('/tecnicos/update/' . $id),
            'validation' => \Config\Services::validation(),
        ]);
    }

    /** Actualizar */
    public function update($id)
    {
        $rules = ['especialidad' => 'required|min_length[3]|max_length[100]'];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->tecModel->update($id, ['especialidad' => $this->request->getPost('especialidad')]);
        return redirect()->to('/tecnicos')->with('msg', 'Técnico actualizado');
    }

    /** Eliminar */
    public function delete($id)
    {
        $this->tecModel->delete($id);
        return redirect()->to('/tecnicos')->with('msg', 'Técnico eliminado');
    }
}
