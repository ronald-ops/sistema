<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TurnosSeeder extends Seeder
{
    public function run()
    {
        DB::table('turnos')->insert([
            [
                'nombre_turno' => 'Mañana',
                'hora_inicio' => '06:00:00',
                'hora_fin' => '14:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre_turno' => 'Tarde',
                'hora_inicio' => '14:00:01',
                'hora_fin' => '18:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre_turno' => 'Noche',
                'hora_inicio' => '18:00:01',
                'hora_fin' => '00:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nombre_turno' => 'Continuo',
                'hora_inicio' => '08:00:00',
                'hora_fin' => '20:00:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
