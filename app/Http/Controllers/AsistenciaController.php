<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Empleado;
use App\Models\BiometricoLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AsistenciaController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with(['biometricoLogs', 'horarios.turno', 'permisos'])->get();
        $asistencias = [];
        $tolerancia = 10; // Tolerancia en minutos para llegar tarde
    
        foreach ($empleados as $empleado) {
            $horarios = $empleado->horarios;
            if ($horarios->isEmpty()) {
                continue;
            }
    
            $logsPorFecha = $empleado->biometricoLogs->groupBy('fecha');
    
            foreach ($logsPorFecha as $fecha => $logs) {
                $fechaLog = \Carbon\Carbon::parse($fecha);
                $diaSemana = $fechaLog->dayOfWeek;
                $logs = $logs->sortBy('hora');
                $permisoActivo = $empleado->permisos->firstWhere('fecha_entrega', $fecha);
    
                foreach ($horarios as $horario) {
                    if (!is_null($horario->pivot->dia_semana) && $horario->pivot->dia_semana != $diaSemana) {
                        continue;
                    }
    
                    $fechaInicio = \Carbon\Carbon::parse($horario->pivot->fecha_inicio);
                    $fechaFin = $horario->pivot->fecha_fin ? \Carbon\Carbon::parse($horario->pivot->fecha_fin) : null;
                    if ($fechaLog->lt($fechaInicio) || ($fechaFin && $fechaLog->gt($fechaFin))) {
                        continue;
                    }
    
                    $entrada = null;
                    $salida = null;
                    $horaEstándarEntrada = \Carbon\Carbon::createFromTimeString($horario->hora_entrada);
                    $horaEstándarSalida = \Carbon\Carbon::createFromTimeString($horario->hora_salida);
    
                    foreach ($logs as $log) {
                        $horaLog = \Carbon\Carbon::createFromTimeString($log->hora);
                        if ($log->estado == 'Entrada' && !$entrada && $horaLog->between($horaEstándarEntrada->copy()->subMinutes(120), $horaEstándarSalida->copy()->addMinutes(30))) {
                            $entrada = $log->hora;
                        }
    
                        if ($log->estado == 'Salida' && !$salida && $horaLog->gte($horaEstándarEntrada) && $horaLog->lte($horaEstándarSalida->copy()->addMinutes(60))) {
                            $salida = $log->hora;
                        }
                    }
    
                    if (!$salida) {
                        $salidaCercana = $logs->where('estado', 'Salida')->first(function ($log) use ($horaEstándarSalida) {
                            $horaLog = \Carbon\Carbon::createFromTimeString($log->hora);
                            return $horaLog->gt($horaEstándarSalida);
                        });
                        $salida = $salidaCercana ? $salidaCercana->hora : null;
                    }
    
                    if (!$salida) {
                        $ultimaSalida = $logs->where('estado', 'Salida')->last();
                        $salida = $ultimaSalida ? $ultimaSalida->hora : null;
                    }
    
                    $nombreTurno = $horario->turno->nombre_turno ?? 'N/A';
                    $horasTrabajadas = null;
                    $observaciones = '';
    
                    if ($permisoActivo) {
                        $tipoPermiso = $permisoActivo->motivo;
                        $observaciones = "Permiso: $tipoPermiso";
                    }
    
                    if (!$entrada && $salida) {
                        $observaciones .= ' | Sin entrada (Descuido)';
                        $entrada = $horario->hora_entrada;
                    }
    
                    if ($entrada && !$salida) {
                        $observaciones .= ' | Sin salida (Descuido)';
                        $salida = $horario->hora_salida;
                    }
    
                    if ($entrada && $salida) {
                        $horaEntrada = \Carbon\Carbon::createFromTimeString($entrada);
                        $horaSalida = \Carbon\Carbon::createFromTimeString($salida);
                        $horasTrabajadas = $horaEntrada->diffInHours($horaSalida);
    
                        if ($horario->turno->Continuo) {
                            $horasTrabajadas -= 1;
                        }
    
                        $horasTrabajadasRedondeadas = round($horasTrabajadas);
    
                        $minutosAtraso = null;
                        if (\Carbon\Carbon::createFromTimeString($entrada) > $horaEstándarEntrada->copy()->addMinutes($tolerancia)) {
                            $minutosAtraso = $horaEstándarEntrada->diffInMinutes(\Carbon\Carbon::createFromTimeString($entrada));
                        }
    
                        // Verificar el tipo de horario y asignar las horas trabajadas a la columna correspondiente
                        $tipoHorario = $horario->pivot->tipo_horario; // Se asume que 'tipo' es la columna en la tabla pivote que indica el tipo de horario
                        $columnaHoras = match ($tipoHorario) {
                            'normal' => 'horas_trabajadas',
                            'docencia' => 'horas_docencia',
                            'capacitacion' => 'horas_capacitacion',
                            default => 'horas_trabajadas',
                        };
    
                        $asistencias[] = [
                            'nombre' => $empleado->nombre,
                            'apellido' => $empleado->apellido,
                            'fecha' => $fecha,
                            'hora_entrada' => $entrada,
                            'hora_salida' => $salida,
                            'minutos_atraso' => $minutosAtraso ? $minutosAtraso . ' min' : 'sin atraso',
                            'horario' => $nombreTurno,
                            'observaciones' => $observaciones,
                            // Inicializar las tres columnas en null para evitar errores de índices faltantes
                            'horas_trabajadas' => null,
                            'horas_docencia' => null,
                            'horas_capacitacion' => null,
                            // Asignar el valor de horas trabajadas a la columna específica
                            $columnaHoras => $horasTrabajadasRedondeadas . ' horas',
                        ];
                        
                    }
                }
            }
        }
    
        usort($asistencias, function($a, $b) {
            return $a['apellido'] <=> $b['apellido']
                ?: $a['nombre'] <=> $b['nombre']
                ?: $a['fecha'] <=> $b['fecha'];
        });
    
        return view('asistencias.index', compact('asistencias'));
    }
    
              
    public function informeMensual(Request $request)
    {
        $year = $request->input('year', date('Y'));

        $months = [];
        $ontime = [];
        $late = [];

        for ($m = 1; $m <= 12; $m++) {
            $ontimeCount = Asistencia::whereMonth('fecha', $m)
                                     ->whereYear('fecha', $year)
                                     ->where('estado_asistencia', '!=', 'Descuido')
                                     ->where('minutos_atraso', 0)
                                     ->count();
            $lateCount = Asistencia::whereMonth('fecha', $m)
                                   ->whereYear('fecha', $year)
                                   ->where('estado_asistencia', '!=', 'Descuido')
                                   ->where('minutos_atraso', '>', 0)
                                   ->count();

            $months[] = date('M', mktime(0, 0, 0, $m, 1));
            $ontime[] = $ontimeCount;
            $late[] = $lateCount;
        }

        return view('home', compact('months', 'ontime', 'late', 'year'));
    }
}
