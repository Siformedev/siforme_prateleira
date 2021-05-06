<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRafflesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('raffle_numbers_start');
            $table->integer('raffle_numbers_end');
            $table->date('draw_date'); //Data do sorteio
            $table->string('img')->nullable();
            $table->integer('numbers_per_person');
            $table->text('rules');
            $table->decimal('price');
            $table->string('premium');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('raffles');
    }
}
