<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionCorreosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracion_correos', function (Blueprint $table) {
            $table->id();
            $table->string("host");
            $table->string("puerto");
            $table->string("encriptado");
            $table->string("correo");
            $table->string("nombre");
            $table->string("password");
            $table->string("driver");
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
        Schema::dropIfExists('configuracion_correos');
    }
}
