<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ReportesImport;
use App\Models\BiometricoLog;

class ReporteController extends Controller
{
    // Muestra el formulario de importación
    public function showImportForm()
    {
        // Obtener los registros ya importados para mostrarlos en la vista
        $biometricoLogs = BiometricoLog::with('empleado')->get(); // Asumiendo que 'empleado' es la relación con el modelo Empleado

        return view('Reporteimportar', compact('biometricoLogs')); // Pasar registros a la vista
    }

    // Maneja la lógica de la importación
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        // Importar los datos desde el archivo usando la clase ReportesImport
        Excel::import(new ReportesImport, $request->file('file'));

        // Redirigir nuevamente al formulario con un mensaje de éxito
        return redirect()->route('importar.form')->with('success', 'Archivo importado y procesado correctamente.');
    }
}
