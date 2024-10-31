<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosTable extends Migration
{
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id(); // Campo id (BIGINT UNSIGNED AUTO_INCREMENT)
            $table->unsignedBigInteger('turno_id');
            $table->date('fecha');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->foreign('turno_id')
                ->references('id')
                ->on('turnos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('horarios');
    }
}
