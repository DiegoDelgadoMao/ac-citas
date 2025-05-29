<?php
/**
 * Valida que la fecha sea hoy o posterior (YYYY-MM-DD).
 */
function is_future_date(string $str): bool
{
    return strtotime($str) >= strtotime(date('Y-m-d'));
}

/**
 * Valida que la hora sea posterior a la hora actual
 * *solo* si la fecha indicada es hoy.
 *
 * Regla de uso:  is_future_time[fecha]
 *
 * @param string $str   Hora HH:MM.
 * @param string $field Nombre del campo fecha indicado entre corchetes.
 * @param array  $data  Todos los datos enviados en el formulario.
 */
function is_future_time(string $str, string $field, array $data): bool
{
    $fecha = $data[$field] ?? '';

    // Si la fecha NO es hoy, la hora no se valida contra el reloj.
    if ($fecha !== date('Y-m-d')) {
        return true;
    }

    return strtotime($str) > strtotime(date('H:i'));
}