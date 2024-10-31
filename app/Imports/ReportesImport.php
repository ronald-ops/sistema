<?php

namespace App\Imports;

use App\Models\BiometricoLog;
use App\Models\Empleado;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ReportesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Comprobamos si la fecha es un número (número de serie de Excel)
        if (is_numeric($row['fecha'])) {
            // Convertimos el número de serie de Excel a una fecha
            $fecha = Carbon::createFromDate(1900, 1, 1)->addDays($row['fecha'] - 2)->format('Y-m-d');
        } else {
            // Si la fecha ya está en el formato correcto
            $fecha = Carbon::parse($row['fecha'])->format('Y-m-d');
        }

        // Comprobamos si la hora es un número (número decimal de Excel)
        if (is_numeric($row['hora'])) {
            // Convertimos el número decimal de Excel a una hora válida
            $hora = gmdate('H:i:s', ($row['hora'] * 86400)); // 86400 segundos en un día
        } else {
            // Si la hora ya está en el formato correcto
            $hora = $row['hora'];
        }

        // Buscar empleado por biometrico_lapaz
        $empleado = Empleado::where('biometrico_lapaz', $row['biometrico_id'])->first();

        if ($empleado) {
            // Determinar el estado de la asistencia (por defecto 'Descuido')
            $estadoAsistencia = $row['estado'] ?? 'Descuido';

            // Verificar si ya existe un registro con los mismos valores
            $existeRegistro = BiometricoLog::where('biometrico_id', $empleado->biometrico_lapaz)
                ->where('fecha', $fecha)
                ->where('hora', $hora)
                ->where('estado', $estadoAsistencia)
                ->exists();

            // Si no existe un registro con los mismos valores, se inserta
            if (!$existeRegistro) {
                return new BiometricoLog([
                    'biometrico_id' => $empleado->biometrico_lapaz,
                    'fecha'         => $fecha,
                    'hora'          => $hora,
                    'estado'        => $estadoAsistencia,
                ]);
            }
        }

        // Si el empleado no se encuentra o ya existe el registro, retornar null para omitir la inserción
        return null;
    }
}
