<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePamentosBoletoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamentos_boleto', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parcela_pagamento_id')->unsigned();
            $table->foreign('parcela_pagamento_id')->references('id')->on('parcelas_pagamentos');
            $table->decimal('valor_pago')->default('0');
            $table->string('invoice_id')->nullable();
            $table->string('payable_with')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('total_cents')->default('0');
            $table->decimal('paid_cents')->default('0');
            $table->string('status')->default('');
            $table->date('paid_at')->nullable();
            $table->string('secure_url')->default('');
            $table->decimal('taxes_paid_cents')->default('0');
            $table->integer('installments')->default('0');
            $table->string('digitable_line')->default('');
            $table->string('barcode')->default('');
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
        Schema::dropIfExists('pagamentos_boleto');
    }
}
