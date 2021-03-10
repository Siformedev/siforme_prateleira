<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLimitPerFormToProductsAndServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_and_services', function (Blueprint $table) {
            $table->integer('limit_per_form')->default(0)->after('limit_per_purchase');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_and_services', function($table) {
            $table->dropColumn('limit_per_form');
        });
    }
}
