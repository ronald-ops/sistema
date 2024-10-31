<?php

// app/Models/Horario.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios'; 
    public $timestamps = false; // Asegúrate de que no se utilicen 'created_at' y 'updated_at'
    
    protected $fillable = [
        'fecha',
        'hora_entrada',
        'hora_salida',
        'turno_id', // Asegúrate de incluir turno_id
    ];

    // Relación con Turno
    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turno_id');
    }

    // Relación con Empleados a través de la tabla pivote
    public function empleados()
    {
        return $this->belongsToMany(Empleado::class, 'empleado_horarios', 'horario_id', 'empleado_id');// Esto almacenará las marcas de tiempo en la tabla pivote
    }
}
