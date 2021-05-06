<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRaffleNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffle_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('raffle_id')->unsigned();
            $table->foreign('raffle_id')->references('id')->on('raffles');
            $table->integer('forming_id')->unsigned();
            $table->foreign('forming_id')->references('id')->on('formings');
            $table->integer('number');
            $table->string('buyer_name')->nullable();
            $table->string('buyer_phone')->nullable();
            $table->string('buyer_email')->nullable();
            $table->string('img')->nullable();
            $table->string('hash');
            $table->date('purchase_date')->nullable(); //Data do sorteio
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
        Schema::dropIfExists('raffle_numbers');
    }
}
