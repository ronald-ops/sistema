<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Departamento;

class SeccionController extends Controller
{
    public function administrativo()
    {
        // Lógica para mostrar la sección Administrativo
        $empleados = Empleado::whereHas('departamento', function ($query) {
            $query->where('nombre_departamento', 'Personal de Planta');
        })->get();

        return view('seccion.administrativo', compact('empleados'));
     
    }

    public function servicios()
    {
        // Lógica para mostrar la sección Servicios
        $empleados = Empleado::whereHas('departamento', function ($query) {
            $query->where('nombre_departamento', 'Personal de Servicios');
        })->get();

        return view('seccion.servicios', compact('empleados'));
        
    }

    public function docentes()
    {
        // Lógica para mostrar la sección Docentes
        $empleados = Empleado::whereHas('departamento', function ($query) {
            $query->where('nombre_departamento', 'Plantel de Docentes');
        })->get();

        return view('seccion.docentes', compact('empleados'));
    }

    public function pasantes()
    {
        // Lógica para mostrar la sección Pasantes
        $empleados = Empleado::whereHas('departamento', function ($query) {
            $query->where('nombre_departamento', 'Personal con Practicas Pre Profecionales');
        })->get();

        return view('seccion.pasantes', compact('empleados'));
    }
    
}
