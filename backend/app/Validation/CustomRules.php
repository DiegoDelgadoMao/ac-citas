<?php
namespace App\Validation;

class CustomRules
{
    /**
     * La fecha debe ser hoy o posterior (YYYY-MM-DD).
     */
    public function is_future_date(string $str): bool
    {
        return strtotime($str) >= strtotime(date('Y-m-d'));
    }

    /**
     * La hora debe ser posterior a la hora actual
     * solo si la fecha indicada es hoy.
     *
     * Uso en la regla:  is_future_time[fecha]
     *
     * @param string $str    Hora HH:MM
     * @param string $fields Nombre del campo fecha indicado entre corchetes
     * @param array  $data   Todos los datos del formulario
     */
    public function is_future_time(string $str, string $fields, array $data): bool
    {
        $fecha = $data[$fields] ?? '';

        // Si la fecha NO es hoy, no se valida la hora
        if ($fecha !== date('Y-m-d')) {
            return true;
        }

        return strtotime($str) > strtotime(date('H:i'));
    }
}
