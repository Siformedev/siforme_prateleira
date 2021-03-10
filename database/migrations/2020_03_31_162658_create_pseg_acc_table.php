<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsegAccTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_pseg', function (Blueprint $table) {
            $table->increments('id');
            $table->string('app_pseg_id');
            $table->string('app_pseg_key');
            $table->string('app_pseg_auth');
            $table->string('pseg_email');
            $table->string('pseg_token');
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
        Schema::table('account_pseg', function (Blueprint $table) {
            //
        });
    }
}
