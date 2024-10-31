<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id(); // Identificador único del empleado
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('cargo', 50);
            $table->unsignedBigInteger('departamento_id');
            $table->unsignedBigInteger('biometrico_lapaz')->unique();
            $table->timestamps();

            // Clave foránea con la tabla departamentos
            $table->foreign('departamento_id')
                ->references('id')
                ->on('departamentos')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
