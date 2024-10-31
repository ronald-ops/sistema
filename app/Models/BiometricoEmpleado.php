<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiometricoEmpleado extends Model
{
    use HasFactory;

    // Definir la tabla asociada
    protected $table = 'biometrico_empleado'; // Está bien, aunque Laravel esperaría 'biometrico_empleados' por convención

    // Campos que pueden ser rellenados
    protected $fillable = [
        'empleado_id',
        'biometrico_id_lapaz',
        'biometrico_id_elalto',
    ];

    // Desactivar los timestamps si no existen en la tabla
    public $timestamps = false;

    // Relación con el modelo Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id'); // Tercer parámetro si 'id' es la clave primaria en empleados
    }
}
