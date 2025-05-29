<?php

namespace App\Controllers;

use App\Models\CitaModel;

class Cliente extends BaseController
{
    public function dashboard()
    {
        $userId = session('user_id');
        $citasM = new CitaModel();
        $stats = [
            'programadas' => $citasM->where(['id_cliente' => $userId, 'estado' => 'Programada'])->countAllResults(),
            'realizadas'  => $citasM->where(['id_cliente' => $userId, 'estado' => 'Realizada'])->countAllResults(),
            'canceladas'  => $citasM->where(['id_cliente' => $userId, 'estado' => 'Cancelada'])->countAllResults(),
        ];
        $stats['total'] = array_sum($stats);

        $upcoming = $citasM
            ->select('citas.*, servicios.tipo_servicio, u.nombre_completo AS tecnico')
            ->join('servicios', 'servicios.id_servicio = citas.id_servicio')
            ->join('tecnicos t', 't.id_tecnico = citas.id_tecnico')
            ->join('usuarios u', 'u.id_usuario = t.id_usuario')
            ->where('id_cliente', $userId)
            ->where('fecha >=', date('Y-m-d'))
            ->orderBy('fecha', 'asc')->orderBy('hora', 'asc')
            ->limit(5)->find();

        return view('dashboard', [
            'title'    => 'Dashboard',
            'userName' => session('user_name'),
            'stats'    => $stats,
            'citas'    => $upcoming,
        ]);
    }
}
