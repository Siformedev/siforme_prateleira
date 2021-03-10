<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWithdrawnToFormandosProdutosEServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formando_produtos_e_servicos', function (Blueprint $table) {
            $table->integer('withdrawn')->nullable()->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('formando_produtos_e_servicos', function($table) {
            $table->dropColumn('withdrawn');
        });
    }
}
