<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvioCorreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envio_correos', function (Blueprint $table) {
            $table->id();
            $table->string("tipo");
            $table->unsignedBigInteger("estudiante_id")->nullable();
            $table->string("nivel", 155)->nullable();
            $table->string("grado", 155)->nullable();
            $table->unsignedBigInteger("paralelo_id")->nullable();
            $table->unsignedBigInteger("materia_id")->nullable();
            $table->string("turno")->nullable();
            $table->text("texto");
            $table->string("archivo")->nullable();
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
        Schema::dropIfExists('envio_correos');
    }
}
