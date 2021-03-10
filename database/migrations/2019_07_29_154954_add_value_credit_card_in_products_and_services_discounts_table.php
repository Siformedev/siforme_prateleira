<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValueCreditCardInProductsAndServicesDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_and_services_discounts', function (Blueprint $table) {
            $table->float('value_credit_card')->after('value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_and_services_discounts', function($table) {
            $table->dropColumn('value_credit_card');
        });
    }
}
