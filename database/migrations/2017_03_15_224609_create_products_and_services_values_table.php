<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsAndServicesValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_and_services_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('products_and_services_id')->unsigned();
            $table->foreign('products_and_services_id')->references('id')->on('products_and_services');
            $table->integer('maximum_parcels');
            $table->float('value');
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
        Schema::dropIfExists('products_and_services_values');
    }
}
