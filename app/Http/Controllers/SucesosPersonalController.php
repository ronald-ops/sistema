<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\SucesosExport;
use Maatwebsite\Excel\Facades\Excel;

class SucesosPersonalController extends Controller
{
    public function index()
    {
        $sucesos = [
            ['no' => 1, 'nombre' => 'Cruz Reynaldo Quisbert Mariaca', 'retrasos' => '0', 'descuidos' => '1', 'pendientes_compensar' => '0', 'cuenta_vacacion' => '0', 'pasantia' => '0', 'servicio_adm' => '0', 'docencia' => '0', 'capacitacion' => '0'],
            ['no' => 2, 'nombre' => 'Kimberly Conde Ticona', 'retrasos' => '16m', 'descuidos' => '1', 'pendientes_compensar' => '0', 'cuenta_vacacion' => '0', 'pasantia' => '0', 'servicio_adm' => '0', 'docencia' => '0', 'capacitacion' => '0'],
        ];

        return view('sucesos.index', compact('sucesos'));
    }

    public function export()
    {
        $sucesos = [
            ['no' => 1, 'nombre' => 'Cruz Reynaldo Quisbert Mariaca', 'retrasos' => '0', 'descuidos' => '1', 'pendientes_compensar' => '0', 'cuenta_vacacion' => '0', 'pasantia' => '0', 'servicio_adm' => '0', 'docencia' => '0', 'capacitacion' => '0'],
            ['no' => 2, 'nombre' => 'Kimberly Conde Ticona', 'retrasos' => '16m', 'descuidos' => '1', 'pendientes_compensar' => '0', 'cuenta_vacacion' => '0', 'pasantia' => '0', 'servicio_adm' => '0', 'docencia' => '0', 'capacitacion' => '0'],
        ];

        return Excel::download(new SucesosExport($sucesos), 'sucesos_personal_mayo_2024.xlsx');
    }
}
