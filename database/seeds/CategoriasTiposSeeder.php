<?php

use Illuminate\Database\Seeder;

class CategoriasTiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias_tipos')->insert([
            'id' => '1',
            'name' => 'convite',
        ]);

        DB::table('categorias_tipos')->insert([
            'id' => '2',
            'name' => 'mesa',
        ]);
    }
}