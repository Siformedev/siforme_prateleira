<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BrindesRetiradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('brindes_retirados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('forming_id')->unsigned();
            $table->integer('brinde_id')->unsigned();
            $table->integer('retirado')->unsigned();
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
        //
    }
}
