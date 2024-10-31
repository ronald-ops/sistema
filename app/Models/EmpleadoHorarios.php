<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpleadoHorarios extends Model
{
    protected $table = 'empleado_horarios';

    protected $fillable = [
        'empleado_id',
        'horario_id',
        'fecha_inicio', 
        'fecha_fin', 
        'tipo_horario',
        'dia_semana',
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
    
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }
}
