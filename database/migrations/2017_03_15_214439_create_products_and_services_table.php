<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsAndServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_and_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->string('name');
            $table->text('description');
            $table->string('img');
            $table->float('value');
            $table->integer('maximum_parcels');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categorias_produtos_e_servicos');
            $table->date('reset_igpm')->nullable();
            $table->integer('termo_id')->nullable();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
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
        Schema::dropIfExists('products_and_services');
    }
}
