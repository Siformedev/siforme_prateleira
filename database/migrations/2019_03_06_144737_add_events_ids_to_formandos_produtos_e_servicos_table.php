<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventsIdsToFormandosProdutosEServicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('formando_produtos_e_servicos', function (Blueprint $table) {
            $table->string('events_ids')->default(0)->after('category_id');
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
            $table->dropColumn('events_ids');
        });
    }
}
