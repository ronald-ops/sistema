<?php

// app/Models/Asistencia.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'fecha',
        'hora_llegada',
        'hora_salida',
        'estado_asistencia',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
    // En el modelo de Asistencia
    public function turno()
    {
    return $this->belongsTo(Turno::class, 'turno_id'); // Cambia 'turno_id' al nombre real de la columna que relaciona ambos modelos
    }

}

