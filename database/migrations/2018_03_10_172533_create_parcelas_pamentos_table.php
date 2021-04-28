<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelasPamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcelas_pagamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parcela_id')->unsigned();
            $table->foreign('parcela_id')->references('id')->on('formandos_produtos_parcelas');
            $table->decimal('valor_pago')->default('0');
            $table->nullableMorphs('typepaind');
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
        Schema::dropIfExists('parcelas_pagamentos');
    }
}
