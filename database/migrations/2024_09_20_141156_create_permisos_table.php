<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->id(); // Campo id (BIGINT UNSIGNED AUTO_INCREMENT)
            $table->unsignedBigInteger('empleado_id'); // Relación con empleados
            $table->date('fecha_entrega');
            $table->text('motivo'); // Campo para describir el motivo
            $table->string('estado', 20); // Estado del permiso (ej. "aprobado", "pendiente")
            $table->time('hora_inicio_permiso')->nullable(); // Hora de inicio del permiso
            $table->time('hora_fin_permiso')->nullable(); // Hora de fin del permiso
            
            // Nuevos campos para tipo de permiso
            $table->string('cargo')->nullable(); // Cargo del empleado (administrativo)
            $table->string('oficina')->nullable(); // Oficina del empleado (administrativo)
            $table->string('materia')->nullable(); // Materia (solo para docentes)
            $table->boolean('reemplazo')->default(false); // Indicador de si hay reemplazo
            $table->string('tipo_permiso', 20)->nullable(); // Para diferenciar permisos (administrativo/docente)
            $table->string('otros')->nullable(); // Motivo adicional "otros" si aplica

            $table->timestamps();

            // Clave foránea con eliminación en cascada
            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
    