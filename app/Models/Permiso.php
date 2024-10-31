<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'fecha_entrega',
        'motivo',
        'hora_inicio_permiso',
        'hora_fin_permiso',
        'cargo',           // Nuevo campo
        'oficina',         // Nuevo campo
        'materia',         // Campo para los docentes
        'reemplazo',       // Indicar si es con o sin reemplazo (booleano)
        'tipo_permiso',    // Diferenciar entre administrativo y docente
        'otros',          // Motivo adicional "otros"
        'estado',
    ];

    // Desactivar timestamps si no se usan
    public $timestamps = false;

    // Cast de fechas y horas
    protected $casts = [
        'fecha_entrega' => 'date',
        'hora_inicio_permiso' => 'datetime:H:i',
        'hora_fin_permiso' => 'datetime:H:i',
    ];

    // Relación con el modelo Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
