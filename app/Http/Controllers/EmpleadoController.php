<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Departamento;
use App\Models\Horario;
use App\Models\EmpleadoHorarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpleadoController extends Controller
{
    // Mostrar todos los empleados con sus horarios y turnos
    public function index()
    {
    $empleados = Empleado::with(['horarios.turno'])->get();
    $horarios = Horario::with('turno')->get(); // Obtener horarios con sus turnos
    return view('empleados.index', compact('empleados', 'horarios'));
    }

    // Mostrar formulario de creación de empleados
    public function create()
    {   
        $departamentos = Departamento::all();
        return view('empleados.create', compact('departamentos'));
    }

    // Guardar un nuevo empleado
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'cargo' => 'required|string|max:50',
            'departamento_id' => 'required|exists:departamentos,id',
            'biometrico_lapaz' => 'required|integer|unique:empleados,biometrico_lapaz',
        ]);

        Empleado::create($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado registrado exitosamente');
    }

    // Mostrar formulario de edición de empleados
    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        $departamentos = Departamento::all();
        $horarios = Horario::all(); // Obtener todos los horarios

        return view('empleados.edit', compact('empleado', 'departamentos', 'horarios'));
    }

    // Obtener datos de un empleado para edición
    public function getEmpleado($id)
    {
        $empleado = Empleado::findOrFail($id);
        return response()->json($empleado);
    }

    // Actualizar los datos de un empleado
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'departamento_id' => 'required|exists:departamentos,id',
            'biometrico_lapaz' => 'required|integer|unique:empleados,biometrico_lapaz,' . $id,
        ]);

        $empleado = Empleado::findOrFail($id);
        $empleado->update($request->all());

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function asignarHorario(Request $request, $id)
    {
        $request->validate([
            'horarios' => 'required|array',
            'horarios.*' => 'exists:horarios,id',
            'fecha_inicio' => 'required|array',
            'fecha_inicio.*' => 'date',
            'fecha_fin' => 'nullable|array',
            'fecha_fin.*' => 'nullable|date|after_or_equal:fecha_inicio.*',
            'dia_semana' => 'required|array',
            'dia_semana.*' => 'integer|min:1|max:7',
            'tipo_horario' => 'required|array',
            'tipo_horario.*' => 'in:normal,docencia,capacitacion', // Ajustado para incluir 'normal'
        ]);
    
        $empleado = Empleado::findOrFail($id);
        
        DB::transaction(function () use ($empleado, $request) {
            foreach ($request->horarios as $index => $horario_id) {
                $empleado->horarios()->attach($horario_id, [
                    'fecha_inicio' => $request->fecha_inicio[$index],
                    'fecha_fin' => $request->fecha_fin[$index] ?? null,
                    'dia_semana' => $request->dia_semana[$index],
                    'tipo_horario' => $request->tipo_horario[$index],
                ]);
            }
        });
    
        return redirect()->route('empleados.index')->with('success', 'Horarios asignados correctamente.');
    }
    
    
    // Obtener horarios de un empleado específico
    public function getHorarios($empleadoId)
    {
        $horarios = EmpleadoHorarios::where('empleado_id', $empleadoId)
            ->with(['horario.turno'])
            ->get();

        $diasSemana = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo',
        ];

        $horarios = $horarios->map(function ($item) use ($diasSemana) {
            return [
                'dia_asignado' => $diasSemana[$item->dia_semana] ?? 'Desconocido',
                'hora_entrada' => $item->horario->hora_entrada ?? 'N/A',
                'hora_salida' => $item->horario->hora_salida ?? 'N/A',
                'tipo_horario' => $item->tipo_horario,
                'turno' => $item->horario->turno ? $item->horario->turno->nombre_turno : 'Sin asignar',
            ];
        });

        return response()->json($horarios);
    }
    public function eliminarHorario($empleadoId, $horarioId)
    {
        try {
            $horario = EmpleadoHorarios::where('empleado_id', $empleadoId)
                ->where('id', $horarioId)
                ->first();
    
            if ($horario) {
                $horario->delete();
                return response()->json(['message' => 'Horario eliminado correctamente.'], 200);
            } else {
                return response()->json(['message' => 'Horario no encontrado.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el horario.'], 500);
        }
    }
    

    // Eliminar un empleado y sus relaciones con horarios
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);

        DB::transaction(function () use ($empleado) {
            $empleado->horarios()->detach();
            $empleado->delete();
        });

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}
