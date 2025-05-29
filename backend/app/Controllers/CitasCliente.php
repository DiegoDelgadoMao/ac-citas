<?php

namespace App\Controllers;

use App\Models\CitaModel;
use App\Models\ServicioModel;
use App\Models\TecnicoModel;

class CitasCliente extends BaseController
{
    private CitaModel $citas;

    public function __construct()
    {
        $this->citas = new CitaModel();
    }

    /** Formulario */
    public function create()
    {
        $data = [
            'title'     => 'Nueva Cita',
            'servicios' => (new ServicioModel())->findAll(),
            'tecnicos'  => (new TecnicoModel())
                ->select('tecnicos.id_tecnico, usuarios.nombre_completo')
                ->join('usuarios', 'usuarios.id_usuario = tecnicos.id_usuario')
                ->findAll(),
            'validation' => \Config\Services::validation(),
        ];
        return view('citas/form_cliente', $data);
    }

    /**
     * Comprueba si existe ya una cita en la misma fecha/hora
     * para el MISMO técnico  o  para el MISMO cliente.
     */
    private function haySolape(int $tecId, int $cliId, string $fecha, string $hora): bool
    {
        return $this->citas
            ->groupStart()
            ->where('id_tecnico', $tecId)
            ->orWhere('id_cliente', $cliId)
            ->groupEnd()
            ->where([
                'fecha'  => $fecha,
                'hora'   => $hora,
                'estado' => 'Programada',
            ])
            ->countAllResults() > 0;
    }


    /** Guardar */
    public function store()
    {
        $rules = [
            'id_servicio' => 'required|is_natural_no_zero',
            'id_tecnico'  => 'required|is_natural_no_zero',
            'fecha'       => 'required|valid_date[Y-m-d]|is_future_date',
            'hora'        => 'required|regex_match[/^\d{2}:\d{2}$/]|is_future_time[fecha]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }
        //--- Parametros a chequear
        $tecId  = (int) $this->request->getPost('id_tecnico');
        $cliId  = (int) session('user_id');
        $fecha  = $this->request->getPost('fecha');
        $hora   = $this->request->getPost('hora');
        //--- Solapamiento técnico o cliente
        if ($this->haySolape($tecId, $cliId, $fecha, $hora)) {
            return redirect()->back()->withInput()
                ->with('msg', 'Ya existe una cita en ese horario');
        }
        $this->citas->insert([
            'id_cliente'  => session('user_id'),
            'id_tecnico'  => $this->request->getPost('id_tecnico'),
            'id_servicio' => $this->request->getPost('id_servicio'),
            'fecha'       => $this->request->getPost('fecha'),
            'hora'        => $this->request->getPost('hora'),
            'estado'      => 'Programada',
        ]);
        return redirect()->to('/dashboard')->with('msg', 'Cita programada con éxito');
    }

    /** Cancelar (opcional) */
    public function cancel($id)
    {
        // asegurarse de que la cita pertenezca al cliente
        $this->citas->where(['id_cita' => $id, 'id_cliente' => session('user_id')])
            ->set(['estado' => 'Cancelada'])
            ->update();
        return redirect()->back()->with('msg', 'Cita cancelada');
    }
}
