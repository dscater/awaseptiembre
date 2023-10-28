<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("materia_id");
            $table->unsignedBigInteger("profesor_materia_id");
            $table->integer("gestion");
            $table->string("nombre", 500);
            $table->text("descripcion")->nullable();
            $table->date("fecha_asignacion");
            $table->date("fecha_limite");
            $table->string("estado", 155);
            $table->date("fecha_registro");
            $table->timestamps();

            $table->foreign("materia_id")->on("materias")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas');
    }
}
