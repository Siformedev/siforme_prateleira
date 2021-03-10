<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormandoProdutosEServicosCateriasTiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formando_produtos_e_servicos_caterias_tipos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fps_id')->unsigned();
            $table->foreign('fps_id')->references('id')->on('formando_produtos_e_servicos');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categorias_tipos');
            $table->integer('quantity')->unsigned();
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
        Schema::dropIfExists('formando_produtos_e_servicos_caterias_tipos');
    }
}
