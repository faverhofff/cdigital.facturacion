<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_entradas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->date('fecha');
            $table->float('total');
            $table->integer('v1000')->nullable();
            $table->integer('v500')->nullable();
            $table->integer('v200')->nullable();
            $table->integer('v100')->nullable();
            $table->integer('v50')->nullable();
            $table->integer('v20')->nullable();
            $table->integer('v10')->nullable();
            $table->integer('v5')->nullable();
            $table->integer('v2')->nullable();
            $table->integer('v1')->nullable();
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
        Schema::drop('caja_entradas');
    }
}
