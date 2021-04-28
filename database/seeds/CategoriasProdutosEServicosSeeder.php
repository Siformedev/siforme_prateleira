<?php

use Illuminate\Database\Seeder;

class CategoriasProdutosEServicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias_produtos_e_servicos')->insert([
            'id' => '1',
            'name' => 'Festa de Formatura',
        ]);
        DB::table('categorias_produtos_e_servicos')->insert([
            'id' => '2',
            'name' => 'Álbum Fotofráfico',
        ]);
        DB::table('categorias_produtos_e_servicos')->insert([
            'id' => '3',
            'name' => 'Colação de Grau',
        ]);
        DB::table('categorias_produtos_e_servicos')->insert([
            'id' => '4',
            'name' => 'Jantar',
        ]);
        DB::table('categorias_produtos_e_servicos')->insert([
            'id' => '5',
            'name' => 'Pré Evento',
        ]);
        DB::table('categorias_produtos_e_servicos')->insert([
            'id' => '6',
            'name' => 'Produtos Extras',
        ]);

    }
}