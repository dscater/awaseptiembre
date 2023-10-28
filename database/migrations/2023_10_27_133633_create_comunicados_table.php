<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComunicadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunicados', function (Blueprint $table) {
            $table->id();
            $table->string("nivel");
            $table->unsignedBigInteger("grado_id");
            $table->unsignedBigInteger("materia_id");
            $table->unsignedBigInteger("paralelo_id");
            $table->text("descripcion");
            $table->date("fecha_inicio");
            $table->date("fecha_fin");
            $table->string("estado", 155);
            $table->date("fecha_registro");
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
        Schema::dropIfExists('comunicados');
    }
}
