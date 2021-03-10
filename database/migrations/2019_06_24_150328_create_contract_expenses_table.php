<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('expenses_categories');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('value');
            $table->date('due_date');
            $table->date('payday')->nullable();
            $table->string('billing_file')->nullable();
            $table->string('payment_file')->nullable();
            $table->boolean('paid');
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
        Schema::dropIfExists('contract_expenses');
    }
}
