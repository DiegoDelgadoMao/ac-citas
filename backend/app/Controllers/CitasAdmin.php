<?php

namespace App\Controllers;

use App\Models\CitaModel;
use CodeIgniter\Pager\Pager;

class CitasAdmin extends BaseController
{
    protected CitaModel $citas;

    public function __construct()
    {
        $this->citas = new CitaModel();
    }

    /** Lista con paginación */
    public function index()
    {
        $page = (int)($this->request->getGet('page') ?? 1);
        $perPage = 10;

        $builder = $this->citas
            ->select('citas.*, s.tipo_servicio,
                      cli.nombre_completo AS cliente,
                      tec.nombre_completo AS tecnico')
            ->join('servicios s', 's.id_servicio = citas.id_servicio')
            ->join('usuarios cli', 'cli.id_usuario = citas.id_cliente')
            ->join('tecnicos t',   't.id_tecnico  = citas.id_tecnico')
            ->join('usuarios tec', 'tec.id_usuario = t.id_usuario')
            ->orderBy('fecha', 'desc')->orderBy('hora', 'desc');

        $data = [
            'title'    => 'Todas las Citas',
            'citas'    => $builder->paginate($perPage, 'citas', $page),
            'pager'    => $this->citas->pager,
            'msg'      => session('msg')
        ];

        return view('citas/index_admin', $data);
    }

    /** Cambiar estado: Programada → Realizada / Cancelada */
    public function cambiar($id, $nuevoEstado)
    {
        if (! in_array($nuevoEstado, ['Realizada', 'Cancelada'])) {
            return redirect()->back()->with('msg', 'Estado no permitido');
        }
        $this->citas->update($id, ['estado' => $nuevoEstado]);
        return redirect()->back()->with('msg', "Cita marcada como {$nuevoEstado}");
    }

    /** Eliminar cita (opcional) */
    public function delete($id)
    {
        $this->citas->delete($id);
        return redirect()->back()->with('msg', 'Cita eliminada');
    }
}
