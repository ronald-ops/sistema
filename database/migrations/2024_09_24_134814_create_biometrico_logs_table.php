<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiometricoLogsTable extends Migration
{
    public function up()
    {
        Schema::create('biometrico_logs', function (Blueprint $table) {
            $table->id(); // Campo id (BIGINT UNSIGNED AUTO_INCREMENT)
            $table->unsignedBigInteger('biometrico_id'); // Corregido a unsignedBigInteger
            $table->date('fecha');
            $table->time('hora');
            $table->string('estado');
            $table->timestamps();

            // Definir la clave foránea
            $table->foreign('biometrico_id')
                  ->references('biometrico_lapaz')->on('empleados')
                  ->onDelete('cascade');

            // Crear un índice en biometrico_id para mejorar el rendimiento
            $table->index('biometrico_id');
         });
    }

    public function down()
    {
        Schema::dropIfExists('biometrico_logs');
    }
}
