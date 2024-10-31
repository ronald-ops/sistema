<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Llama a los seeders específicos que quieras ejecutar
        $this->call([
            DepartamentosTableSeeder::class,
            EmpleadosSeeder::class,
            
            // Agrega aquí otros seeders
        ]);
    }
}
