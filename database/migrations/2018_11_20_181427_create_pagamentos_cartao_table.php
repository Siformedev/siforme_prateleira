<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagamentosCartaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamentos_cartao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parcela_pagamento_id')->unsigned();
            $table->foreign('parcela_pagamento_id')->references('id')->on('parcelas_pagamentos');
            $table->decimal('items_total_cents')->default('0');
            $table->string('invoice_id')->nullable();
            $table->string('payable_with')->nullable();
            $table->string('status')->default('');
            $table->date('due_date')->nullable();
            $table->decimal('total')->nullable();
            $table->decimal('taxes_paid')->nullable();
            $table->decimal('total_paid')->nullable();
            $table->decimal('total_overpaid')->nullable();
            $table->decimal('paid')->nullable();
            $table->string('secure_id')->nullable();
            $table->string('secure_url')->default('');
            $table->integer('installments')->nullable();
            $table->integer('transaction_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->date('paid_at')->nullable();
            $table->tinyInteger('deleted')->default(0);
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
        Schema::dropIfExists('pagamentos_cartao');
    }
}
