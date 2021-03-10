<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConvitesExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convites_extras', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->string('name');
            $table->text('description');
            $table->string('img');
            $table->float('value');
            $table->integer('maximum_parcels');
            $table->integer('category_id');
            $table->date('reset_igpm');
            $table->integer('amount_invitation')->default(0);
            $table->integer('amount_tables')->default(0);
            $table->integer('photo_album')->default(0);
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
        Schema::dropIfExists('convites_extras');
    }
}
