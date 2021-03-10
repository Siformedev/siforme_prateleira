<?php

use Illuminate\Database\Seeder;

class ProductsAndServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products_and_services')->insert([
            'contract_id' => '1',
            'name' => 'Formatura Pacote C/ 1 Mesa e 10 Convites',
            'description' => 'Formatura Pacote C/ 1 Mesa e 10 Convites.',
            'img' => 'https://images.emojiterra.com/mozilla/512px/1f393.png',
            'value' => '3883.58',
            'maximum_parcels' => '30',
            'category_id' => '1',
            'reset_igpm' => '2019-03-01',
            'termo_id' => '1',
            'date_start' => '2020-03-10',
            'date_end' => '2021-02-20',
        ]);

        DB::table('products_and_services')->insert([
            'contract_id' => '1',
            'name' => 'Kit Álbum de Formatura',
            'description' => 'Álbum Gráfico 24X30, Laminado Com 40 Páginas, Capa Dura Laminada Matte, Caixa Protetora, com Pen Drive e DVD editado com melhores momentos do Baile',
            'img' => 'https://cdn4.iconfinder.com/data/icons/flatified/512/photos.png',
            'value' => '3000',
            'maximum_parcels' => '30',
            'category_id' => '2',
            'termo_id' => '2',
            'date_start' => '2020-03-10',
            'date_end' => '2021-02-20',
        ]);

        DB::table('products_and_services')->insert([
            'contract_id' => '1',
            'name' => 'Convite Extra de Formatura',
            'description' => 'Convite Extra (Não da direito a mesa nem a cadeira)',
            'img' => 'https://previews.123rf.com/images/ahasoft2000/ahasoft20001603/ahasoft2000160303981/54302940-ticket-vector-toolbar-icon-for-software-design-style-is-a-gradient-icon-symbol-on-a-white-background-Stock-Photo.jpg',
            'value' => '330',
            'maximum_parcels' => '12',
            'category_id' => '6',
            'termo_id' => '3',
            'date_start' => '2020-03-10',
            'date_end' => '2021-02-20',
        ]);

        DB::table('products_and_services')->insert([
            'contract_id' => '1',
            'name' => 'Combo Mesa Extra de Formatura C/ 10 Convites',
            'description' => 'Combo de 1 Mesa com 10 Convites',
            'img' => 'https://image.ibb.co/dpkq3S/54302940_ticket_vector_toolbar_icon_for_software_design_style_is_a_gradient_icon_symbol_on_a_white_background_Stock_Photo.jpg',
            'value' => '4000',
            'maximum_parcels' => '12',
            'category_id' => '6',
            'termo_id' => '3',
            'date_start' => '2020-03-10',
            'date_end' => '2021-02-20',
        ]);

    }
}
