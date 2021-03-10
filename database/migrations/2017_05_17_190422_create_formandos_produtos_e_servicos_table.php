<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormandosProdutosEServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formando_produtos_e_servicos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forming_id')->unsigned();
            $table->foreign('forming_id')->references('id')->on('formings');
            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->string('name');
            $table->text('description');
            $table->string('img');
            $table->float('value');
            $table->float('discounts');
            $table->integer('parcels');
            $table->integer('payday');
            $table->integer('termo_id');
            $table->integer('amount')->default(0);
            $table->date('reset_igpm')->nullable();
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categorias_produtos_e_servicos');
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
        Schema::dropIfExists('formando_produtos_e_servicos');
    }
}
