<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadoHorariosTable extends Migration
{
    public function up()
    {
        Schema::create('empleado_horarios', function (Blueprint $table) {
            $table->id(); // Identificador único para la relación
            $table->unsignedBigInteger('empleado_id'); // Relacionado con la tabla empleados
            $table->unsignedBigInteger('horario_id'); // Relacionado con la tabla horarios
            $table->date('fecha_inicio'); // Fecha de inicio del horario
            $table->date('fecha_fin')->nullable(); // Fecha de fin del horario, puede ser null
            $table->string('tipo_horario');
            $table->integer('dia_semana')->nullable(); // Día de la semana (1=Lunes, 7=Domingo)
            $table->timestamps();

            // Definir la clave foránea con la tabla empleados
            $table->foreign('empleado_id')
                ->references('id')
                ->on('empleados')
                ->onDelete('cascade'); // Si se borra el empleado, elimina los horarios asignados

            // Definir la clave foránea con la tabla horarios
            $table->foreign('horario_id')
                ->references('id')
                ->on('horarios')
                ->onDelete('cascade'); // Si se borra el horario, elimina las asignaciones a empleados
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleado_horarios'); // Elimina la tabla en caso de rollback
    }
}
