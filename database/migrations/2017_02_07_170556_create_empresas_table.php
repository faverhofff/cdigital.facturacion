<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('nombre_corto');
            $table->string('rfc');
            $table->string('calle')->nullable();
            $table->string('numeroInterior')->nullable();
            $table->string('numeroExterior')->nullable();
            $table->string('colonia')->nullable();
            $table->string('delegacion')->nullable();
            $table->string('municipio')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('estado')->nullable();
            $table->string('codigoPostal')->nullable();
            $table->string('correo_1')->nullable();
            $table->string('correo_2')->nullable();
            $table->string('correo_3')->nullable();
            $table->string('sucursal_calle')->nullable();
            $table->string('sucursal_numero')->nullable();
            $table->string('sucursal_colonia')->nullable();
            $table->string('sucursal_ciudad')->nullable();
            $table->string('sucursal_estado')->nullable();
            $table->string('sucursal_codigoPostal')->nullable();
            $table->string('banco_1')->nullable();
            $table->string('datos_banco_1')->nullable();
            $table->string('cuenta_banco_1')->nullable();
            $table->string('banco_2')->nullable();
            $table->string('datos_banco_2')->nullable();
            $table->string('cuenta_banco_2')->nullable();
            $table->string('banco_3')->nullable();
            $table->string('datos_banco_3')->nullable();
            $table->string('cuenta_banco_3')->nullable();
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
        Schema::drop('empresas');
    }
}
