<?php

// app/Models/Turno.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_turno',
        'hora_inicio',
        'hora_fin',
    ];

    // Desactivar timestamps si no se usan en la tabla
    public $timestamps = false; // Solo si la tabla turnos no tiene 'created_at' y 'updated_at'

    // Castear los campos de hora si es necesario
    protected $casts = [
        'hora_inicio' => 'datetime:H:i', // Castear como hora
        'hora_fin' => 'datetime:H:i', // Castear como hora
    ];
    
}
