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
            $table->unsignedBigInteger("user_id");
            $table->integer("gestion");
            $table->string("nivel");
            $table->string("grado", 155);
            $table->unsignedBigInteger("materia_id");
            $table->unsignedBigInteger("paralelo_id");
            $table->string("turno", 155);
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
