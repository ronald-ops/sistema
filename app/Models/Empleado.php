<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmpleadoHorarios;

class Empleado extends Model
{
    use HasFactory;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'apellido',
        'cargo',
        'departamento_id',
        'biometrico_lapaz',
    ];

    // Desactivar timestamps si no se usan en la tabla
    public $timestamps = false; // Solo si la tabla empleados no tiene 'created_at' y 'updated_at'

    // Relación con el modelo BiometricoLog
    public function biometricoLogs()
    {
        return $this->hasMany(BiometricoLog::class, 'biometrico_id', 'biometrico_lapaz');
    }

    // Relación con el modelo Departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function horarios()
{
    return $this->belongsToMany(Horario::class, 'empleado_horarios')->withPivot('fecha_inicio', 'fecha_fin', 'dia_semana', 'tipo_horario');
}
    
    public function empleadoHorarios() 
    {
        return $this->hasMany(EmpleadoHorarios::class);
    }

    public function permisos()
    {
        return $this->hasMany(Permiso::class, 'empleado_id', 'id'); // Ajusta los nombres de las columnas si es necesario
    }

}
