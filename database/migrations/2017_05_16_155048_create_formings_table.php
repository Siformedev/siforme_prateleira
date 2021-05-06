<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('cpf');
            $table->string('rg');
            $table->date('date_nascimento');
            $table->string('img')->default('assets/common/img/avatar.png');
            $table->string('sexo');
            $table->string('cep');
            $table->string('logradouro');
            $table->string('numero');
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('email');
            $table->string('telefone_residencial')->nullable();
            $table->string('telefone_celular');
            $table->string('nome_do_pai')->nullable();
            $table->string('email_do_pai')->nullable();
            $table->string('telefone_celular_pai')->nullable();
            $table->string('nome_da_mae')->nullable();
            $table->string('email_da_mae')->nullable();
            $table->string('telefone_celular_mae')->nullable();
            $table->float('altura');
            $table->string('camiseta');
            $table->string('calcado');
            $table->integer('curso_id');
            $table->integer('periodo_id');
            $table->date('dt_adesao');
            $table->integer('comissao')->default(0);
            $table->tinyInteger('status');
            $table->string('valid');
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
        Schema::dropIfExists('formings');
    }
}
