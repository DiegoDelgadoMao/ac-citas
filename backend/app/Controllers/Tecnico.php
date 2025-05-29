<?php

namespace App\Controllers;

use App\Models\CitaModel;

class Tecnico extends BaseController
{
    public function dashboard()
    {
        $userId = session('user_id');
        $tec = (new \App\Models\TecnicoModel())
            ->select('id_tecnico')
            ->where('id_usuario', $userId)
            ->first();
        if (!$tec) {
            return redirect()->back()->with('msg', 'No tienes perfil de técnico');
        }
        $idTecnico = $tec['id_tecnico'];
        $fecha  = $this->request->getGet('f')
            ?? date('Y-m-d');
        $fechas = [
            date('Y-m-d', strtotime('-1 day', strtotime($fecha))),
            $fecha,
            date('Y-m-d', strtotime('+1 day', strtotime($fecha))),
        ];
        $citasM = new CitaModel();
        // Builder con filtros
        $builder = $citasM
            ->select('citas.*, s.tipo_servicio,
                  u.nombre_completo AS cliente')
            ->join('servicios s', 's.id_servicio = citas.id_servicio')
            ->join('usuarios  u', 'u.id_usuario  = citas.id_cliente')
            ->where('citas.id_tecnico', $idTecnico)
            ->where('citas.fecha', $fecha)          // ← aquí usamos $fecha
            ->orderBy('hora', 'asc');
        $citasHoy = $builder->findAll();
        // Contadores
        $stats = [
            'programadas' => 0,
            'realizadas'  => 0,
            'canceladas'  => 0,
            'total'       => 0,
        ];
        foreach ($citasHoy as $c) {
            $stats[strtolower($c['estado']) . 's']++;
            $stats['total']++;
        }
        return view('tecnico/dashboard', [
            'title'    => 'Panel Técnico',
            'userName' => session('user_name'),
            'stats'    => $stats,
            'citas'    => $citasHoy,
            'selected' => $fecha,     // para el <input type="date">
            'fechas'   => $fechas,
        ]);
    }



    public function completar($id)
    {
        $userId = session('user_id');
        $tec = (new \App\Models\TecnicoModel())
            ->select('id_tecnico')
            ->where('id_usuario', $userId)
            ->first();
        if (!$tec) {
            return redirect()->back()->with('msg', 'No tienes perfil de técnico');
        }
        $idTecnico = $tec['id_tecnico'];
        if (!$idTecnico) {
            return redirect()->back()->with('msg', 'No tienes perfil de técnico');
        }
        $citas = new \App\Models\CitaModel();
        // 2️⃣ Buscar la cita y validar que sea suya y programada
        $cita = $citas->where([
            'id_cita'    => $id,
            'id_tecnico' => $idTecnico,
            'estado'     => 'Programada',
        ])->first();
        if (! $cita) {
            return redirect()->back()->with('msg', 'Cita no válida o ya procesada');
        }
        // 3️⃣ Actualizar estado
        $citas->update($id, ['estado' => 'Realizada']);
        // 4️⃣ Registrar notificación (opcional, tabla notificaciones)
        // (new \App\Models\NotificacionModel())->insert([
        //     'id_usuario'  => $cita['id_cliente'],
        //     'id_cita'     => $id,
        //     'canal'       => 'Email',
        //     'mensaje'     => 'Tu servicio ha sido marcado como realizado.',
        //     'fecha_envio' => date('Y-m-d H:i:s'),
        // ]);
        // 5️⃣ Volver con mensaje de éxito
        return redirect()->back()->with('msg', 'Cita marcada como realizada');
    }
}
