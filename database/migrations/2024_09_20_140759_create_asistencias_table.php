<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciasTable extends Migration
{
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id(); // Campo id (BIGINT UNSIGNED AUTO_INCREMENT)
            $table->unsignedBigInteger('empleado_id'); // Corregido a unsignedBigInteger
            $table->date('fecha');
            $table->time('hora_llegada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->integer('minutos_atraso')->default(0);
            $table->enum('estado_asistencia', ['presente', 'retraso', 'falta']);
            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistencias');
    }
}
