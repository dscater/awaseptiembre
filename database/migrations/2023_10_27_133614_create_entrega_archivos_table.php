<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntregaArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrega_archivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("entrega_id");
            $table->string("link");
            $table->timestamps();
            $table->foreign("entrega_id")->on("entregas")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrega_archivos');
    }
}
