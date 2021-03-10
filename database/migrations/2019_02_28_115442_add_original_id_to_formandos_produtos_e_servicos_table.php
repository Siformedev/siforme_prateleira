<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOriginalIdToFormandosProdutosEServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formando_produtos_e_servicos', function (Blueprint $table) {
            $table->integer('original_id')->default(0)->after('category_id');
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
            $table->dropColumn('original_id');
        });
    }
}
