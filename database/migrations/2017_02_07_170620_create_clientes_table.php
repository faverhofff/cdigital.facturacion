<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('rfc');
            $table->string('calle')->nullable();
            $table->string('noExterior')->nullable();
            $table->string('colonia')->nullable();
            $table->string('municipio')->nullable();
            $table->string('estado')->nullable();
            $table->string('pais')->nullable();
            $table->string('codigoPostal')->nullable();
            $table->integer('cliente_promotor_id')->unsigned()->nullable();
            $table->timestamps();

            $table->index(['cliente_promotor_id']);
            $table->foreign('cliente_promotor_id')->references('id')->on('cliente_promotors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clientes');
    }
}
