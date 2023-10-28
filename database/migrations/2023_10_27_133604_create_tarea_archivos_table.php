<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareaArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarea_archivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("tarea_id");
            $table->string("link");
            $table->timestamps();
            $table->foreign("tarea_id")->on("tareas")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarea_archivos');
    }
}
