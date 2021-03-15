<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('institution');
            $table->integer('conclusion_year');
            $table->integer('conclusion_month');
            $table->date('signature_date');
            $table->date('birthday_date');
            $table->tinyInteger('igpm')->default(1);
            $table->string('email');
            $table->string('code');
            // $table->string('periodos');
            $table->string('valid');
            $table->integer('pseg_acc');
            $table->string('tipo_pagamento');
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
        Schema::dropIfExists('contracts');
    }
}
