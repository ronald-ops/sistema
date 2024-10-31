<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Asistencia;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $adminCount = Empleado::whereHas('departamento', function ($query) {
            $query->where('nombre_departamento', 'personal de Planta');
        })->count();

        $servicesCount = Empleado::whereHas('departamento', function ($query) {
            $query->where('nombre_departamento', 'Personal de Servicios');
        })->count();

        $teachersCount = Empleado::whereHas('departamento', function ($query) {
            $query->where('nombre_departamento', 'Plantel de Docentes');
        })->count();

        $internsCount = Empleado::whereHas('departamento', function ($query) {
            $query->where('nombre_departamento', 'Personal con Practicas Pre Profecionales');
        })->count();

        $year = $request->input('year', date('Y'));

        // Obtener datos para el gráfico de asistencia
        $months = [];
        $late = [];
        $ontime = [];

        for ($m = 1; $m <= 12; $m++) {
            $month = date('M', mktime(0, 0, 0, $m, 1));
            $months[] = $month;

            $ontimeCount = Asistencia::whereMonth('fecha', $m)
                ->where('estado_asistencia', 1)
                ->whereYear('fecha', $year)
                ->count();
            $ontime[] = $ontimeCount;

            $lateCount = Asistencia::whereMonth('fecha', $m)
                ->where('estado_asistencia', 0)
                ->whereYear('fecha', $year)
                ->count();
            $late[] = $lateCount;
        }

        return view('home', compact('adminCount', 'servicesCount', 'teachersCount', 'internsCount', 'months', 'late', 'ontime', 'year'));
    }

    
}
