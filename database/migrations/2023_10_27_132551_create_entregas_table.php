<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("inscripcion_id");
            $table->unsignedBigInteger("materia_id");
            $table->unsignedBigInteger("tarea_id");
            $table->text("observaciones")->nullable();
            $table->date("fecha_entrega")->nullable();
            $table->double("calificacion", 8, 2)->nullable();
            $table->string("estado", 155);
            $table->string("enviado", 155);
            $table->date("fecha_registro")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entregas');
    }
}
