<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsAndServicesCategoriesTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_and_services_categories_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pas_id')->unsigned();
            $table->foreign('pas_id')->references('id')->on('products_and_services');
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
        Schema::dropIfExists('products_and_services_categories_type');
    }
}
