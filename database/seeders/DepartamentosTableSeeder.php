<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartamentosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('departamentos')->insert([
            ['nombre_departamento' => 'Personal de Planta'],
            ['nombre_departamento' => 'Personal de Servicios'],
            ['nombre_departamento' => 'Personal con Practicas Pre Profecionales'],
            ['nombre_departamento' => 'Plantel de Docentes'],
        ]);
    }
}
