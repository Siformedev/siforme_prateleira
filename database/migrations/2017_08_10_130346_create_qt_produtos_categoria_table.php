<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQtProdutosCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qt_produtos_categorias', function (Blueprint $table) {
            $table->increments('id');
            $table->nullableMorphs('qual_produto');
            $table->integer('category_tipo');
            $table->integer('category_produto');
            $table->integer('quantidade');
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
        Schema::dropIfExists('qt_produtos_categorias');
    }
}
