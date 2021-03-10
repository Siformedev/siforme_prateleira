<?php

use Illuminate\Database\Seeder;

class ProductsAndServicesDiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id=1
        DB::table('products_and_services_discounts')->insert([
            'products_and_services_id' => '1',
            'maximum_parcels' => '1',
            'value' => '10',
            'value_credit_card' => '0',
            'date_start' => '2018-03-01',
            'date_end' => '2018-06-01',
        ]);

        DB::table('products_and_services_discounts')->insert([
            'products_and_services_id' => '1',
            'maximum_parcels' => '3',
            'value' => '10',
            'value_credit_card' => '0',
            'date_start' => '2018-03-01',
            'date_end' => '2018-06-01',
        ]);

        DB::table('products_and_services_discounts')->insert([
            'products_and_services_id' => '1',
            'maximum_parcels' => '6',
            'value' => '7',
            'value_credit_card' => '0',
            'date_start' => '2018-03-01',
            'date_end' => '2018-06-01',
        ]);

        DB::table('products_and_services_discounts')->insert([
            'products_and_services_id' => '1',
            'maximum_parcels' => '12',
            'value' => '5',
            'value_credit_card' => '0',
            'date_start' => '2018-03-01',
            'date_end' => '2018-06-01',
        ]);
    }
}
