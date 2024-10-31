<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Turno;

class HorarioController extends Controller
{
    public function create()
    {
        // Reemplaza empleados por turnos
        $turnos = Turno::all();
        return view('horarios.create', compact('turnos'));
    }

    public function index()
    {
        // Obtén todos los horarios con la relación de los turnos
        $horarios = Horario::with('turno')->get();
        // Pasa los turnos y horarios a la vista
        $turnos = Turno::all();
        return view('horarios.index', compact('horarios', 'turnos'));
    }

    public function edit($id)
    {
        $horario = Horario::findOrFail($id);
        $turnos = Turno::all();
        return view('horarios.edit', compact('horario', 'turnos'));
    }

    public function update(Request $request, $id)
    {
        $horario = Horario::findOrFail($id);
        // Actualiza el horario con los datos del request
        $horario->update($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente');
    }

    public function store(Request $request)
    {
        // Validar los datos recibidos del formulario
        $request->validate([
            'turno_id' => 'required|exists:turnos,id',
            'fecha' => 'required|date',
            'hora_entrada' => 'required',
            'hora_salida' => 'required',
        ]);

        // Crear un nuevo horario
        Horario::create([
            'turno_id' => $request->input('turno_id'), // Usamos turno_id
            'fecha' => $request->input('fecha'),
            'hora_entrada' => $request->input('hora_entrada'),
            'hora_salida' => $request->input('hora_salida'),
        ]);

        // Redirigir a la vista de listado de horarios con un mensaje de éxito
        return redirect()->route('horarios.index')->with('success', 'Horario creado exitosamente');
    }

    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);
        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente');
    }
}
