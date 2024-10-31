<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Empleado;

class EmpleadosSeeder extends Seeder
{
    public function run()
    {
        $empleados = [
            // Personal de Planta
            ['nombre' => 'Cruz Reynaldo', 'apellido' => 'Quisbert Mariaca', 'cargo' => 'Rector', 'departamento_id' => 1, 'biometrico_id_lapaz' => 2],
            ['nombre' => 'Kimberly', 'apellido' => 'Conde Ticona', 'cargo' => 'Administradora', 'departamento_id' => 1, 'biometrico_id_lapaz' => 3],
            ['nombre' => 'Rocio Abigail', 'apellido' => 'Flores Montaño', 'cargo' => 'Directora Academica', 'departamento_id' => 1, 'biometrico_id_lapaz' => 5],
            ['nombre' => 'Carlos Alberto', 'apellido' => 'Patiño Maizares', 'cargo' => 'Contador', 'departamento_id' => 1, 'biometrico_id_lapaz' => 4],
            ['nombre' => 'Sonia Flores', 'apellido' => 'Guarachi', 'cargo' => 'Secretaria', 'departamento_id' => 1, 'biometrico_id_lapaz' => 270],
            ['nombre' => 'Victoria', 'apellido' => 'Sillo Cutipa', 'cargo' => 'Personal de Planta', 'departamento_id' => 1, 'biometrico_id_lapaz' => 154],
            ['nombre' => 'Yesenia', 'apellido' => 'Apaza Callisaya', 'cargo' => 'Administradora', 'departamento_id' => 1, 'biometrico_id_lapaz' => 261],
            ['nombre' => 'Inés Sara', 'apellido' => 'Gutierrez', 'cargo' => 'Contadora', 'departamento_id' => 1, 'biometrico_id_lapaz' => 12],
            ['nombre' => 'Carmen Rosa', 'apellido' => 'Matias Nicolau', 'cargo' => 'Secretaria', 'departamento_id' => 1, 'biometrico_id_lapaz' => 6],
            ['nombre' => 'Lucy Chui', 'apellido' => 'Quispe', 'cargo' => 'Personal de Planta', 'departamento_id' => 1, 'biometrico_id_lapaz' => 351],
            ['nombre' => 'Rodolfo', 'apellido' => 'Apaza Mamani', 'cargo' => 'Personal de Planta', 'departamento_id' => 1, 'biometrico_id_lapaz' => 1011],

            // Personal de Servicios
            ['nombre' => 'Jorge Luis', 'apellido' => 'Quispe Coronel', 'cargo' => 'Director Academico', 'departamento_id' => 2, 'biometrico_id_lapaz' => 218],
            ['nombre' => 'Alejandra Paola', 'apellido' => 'Chino Casilla', 'cargo' => 'Auxiliar Contadora', 'departamento_id' => 2, 'biometrico_id_lapaz' => 600],
            ['nombre' => 'Luz Roxana', 'apellido' => 'Callisaya Mamani', 'cargo' => 'Auxiliar Cajas', 'departamento_id' => 2, 'biometrico_id_lapaz' => 219],
            ['nombre' => 'Lizeth Alison', 'apellido' => 'Chipana Chuquimia', 'cargo' => 'Personal de Servicios', 'departamento_id' => 2, 'biometrico_id_lapaz' => 602],
            ['nombre' => 'Ines Raquel', 'apellido' => 'Tito Cutli', 'cargo' => 'Personal de Servicios', 'departamento_id' => 2, 'biometrico_id_lapaz' => 510],
            ['nombre' => 'Sergio Antonio', 'apellido' => 'Luque Montoya', 'cargo' => 'Personal de Servicios', 'departamento_id' => 2, 'biometrico_id_lapaz' => 428],
            ['nombre' => 'Wilmer', 'apellido' => 'Coaquira Tiñini', 'cargo' => 'Director Academico', 'departamento_id' => 2, 'biometrico_id_lapaz' => 505],
            ['nombre' => 'Cielo Dayana', 'apellido' => 'Calderon Mamani', 'cargo' => 'Personal de Servicios', 'departamento_id' => 2, 'biometrico_id_lapaz' => 616],

            // Personal con Práctica Pre profesional
            ['nombre' => 'Erika Joselin', 'apellido' => 'Carranza Mamani', 'cargo' => 'Práctica Pre profesional', 'departamento_id' => 3, 'biometrico_id_lapaz' => 618],
            ['nombre' => 'Steven Vidal', 'apellido' => 'Paco Rada', 'cargo' => 'Práctica Pre profesional', 'departamento_id' => 3, 'biometrico_id_lapaz' => 619],
            ['nombre' => 'Jhosida Valdez', 'apellido' => 'Juarez', 'cargo' => 'Práctica Pre profesional', 'departamento_id' => 3, 'biometrico_id_lapaz' =>  521],
            ['nombre' => 'Darwin Orlando', 'apellido' => 'Camacho Camacho', 'cargo' => 'Práctica Pre profesional', 'departamento_id' => 3, 'biometrico_id_lapaz' => 522],
            ['nombre' => 'Samuel Ronald', 'apellido' => 'Laura Condori', 'cargo' => 'Práctica Pre profesional', 'departamento_id' => 3, 'biometrico_id_lapaz' => 523],
            ['nombre' => 'Luz Lizeth', 'apellido' => 'Chujo Rivas', 'cargo' => 'Práctica Pre profesional', 'departamento_id' => 3, 'biometrico_id_lapaz' => 231],
            ['nombre' => 'Paola', 'apellido' => 'Poma', 'cargo' => 'Práctica Pre profesional', 'departamento_id' => 3, 'biometrico_id_lapaz' => 1026],
            ['nombre' => 'Alba Wara', 'apellido' => 'Cachi Huanto', 'cargo' => 'Práctica Pre profesional', 'departamento_id' => 3, 'biometrico_id_lapaz' => 229],

            // Plantel Docente Carrera de Gastronomía
            ['nombre' => 'Carlos Andres', 'apellido' => 'Vilar Yañez', 'cargo' => 'Docente Gastronomía', 'departamento_id' => 4, 'biometrico_id_lapaz' => 518],
            ['nombre' => 'Claudia Abigail', 'apellido' => 'Alaca Mamani', 'cargo' => 'Docente Gastronomía', 'departamento_id' => 4, 'biometrico_id_lapaz' => 1000],
            ['nombre' => 'Claudia Alejandra', 'apellido' => 'Berthinh', 'cargo' => 'Docente Gastronomía', 'departamento_id' => 4, 'biometrico_id_lapaz' => 1030],
            ['nombre' => 'Eddy Pablo', 'apellido' => 'Mamani Mayta', 'cargo' => 'Docente Gastronomía', 'departamento_id' => 4, 'biometrico_id_lapaz' => 501],
            ['nombre' => 'Eduardo', 'apellido' => 'Flores Illanes', 'cargo' => 'Docente Gastronomía', 'departamento_id' => 4, 'biometrico_id_lapaz' => 519],
            ['nombre' => 'Jorge', 'apellido' => 'Cuevas Rodriguez', 'cargo' => 'Docente Gastronomía', 'departamento_id' => 4, 'biometrico_id_lapaz' => 303],
            ['nombre' => 'Joshua David', 'apellido' => 'Artovar Alejandro', 'cargo' => 'Docente Gastronomía', 'departamento_id' => 4, 'biometrico_id_lapaz' => 200],
            ['nombre' => 'Judith Pamela', 'apellido' => 'Sandy Caldon', 'cargo' => 'Docente Gastronomía', 'departamento_id' => 4, 'biometrico_id_lapaz' => 503],
            ['nombre' => 'Lupe Milenka', 'apellido' => 'Burgos Mamani', 'cargo' => 'Docente Gastronomía', 'departamento_id' => 4, 'biometrico_id_lapaz' => 1036],
            ['nombre' => 'Marcelo Eduardo', 'apellido' => 'Almendares Flores', 'cargo' => 'Docente Gastronomía', 'departamento_id' => 4, 'biometrico_id_lapaz' => 220],
        ];

        foreach ($empleados as $empleado) {
            Empleado::create([
                'nombre' => $empleado['nombre'],
                'apellido' => $empleado['apellido'],
                'cargo' => $empleado['cargo'],
                'departamento_id' => $empleado['departamento_id'],
                'biometrico_lapaz' => $empleado['biometrico_id_lapaz'], // Campo añadido
            ]);
        }
    }
}
