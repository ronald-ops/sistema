<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacacionesTable extends Migration
{
    public function up()
    {
        Schema::create('vacaciones', function (Blueprint $table) {
            $table->id(); // Campo id (BIGINT UNSIGNED AUTO_INCREMENT)
            $table->unsignedBigInteger('empleado_id'); // Corregido a unsignedBigInteger
            $table->integer('saldo_vacaciones'); // Saldo de días de vacaciones
            $table->timestamps();

            $table->foreign('empleado_id')->references('id')->on('empleados')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vacaciones');
    }
}
