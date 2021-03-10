<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormandosProdutosParcelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formandos_produtos_parcelas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('formandos_produtos_id')->unsigned();
            $table->foreign('formandos_produtos_id')->references('id')->on('formando_produtos_e_servicos');
            $table->integer('formandos_id')->unsigned();
            $table->foreign('formandos_id')->references('id')->on('formings');
            $table->integer('contrato_id')->unsigned();
            $table->foreign('contrato_id')->references('id')->on('contracts');
            $table->date('dt_vencimento');
            $table->integer('numero_parcela');
            $table->decimal('valor')->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('formandos_produtos_parcelas');
    }
}
