<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiometricoLog extends Model
{
    use HasFactory;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'biometrico_id',
        'fecha',
        'hora',
        'estado',
    ];

    // Desactivar timestamps si no se usan en la tabla
    public $timestamps = false;
    // Relación con el modelo Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'biometrico_id', 'biometrico_lapaz'); // Suponiendo que 'biometrico_lapaz' es único
    }
}
