<?php

use Illuminate\Database\Seeder;

class ProductsAndServicesValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products_and_services_values')->insert([
            'products_and_services_id' => '1',
            'maximum_parcels' => '30',
            'value' => '3883.58',
            'date_start' => '2020-03-01',
            'date_end' => '2021-12-31',
        ]);

        DB::table('products_and_services_values')->insert([
            'products_and_services_id' => '2',
            'maximum_parcels' => '30',
            'value' => '3000',
            'date_start' => '2020-03-01',
            'date_end' => '2021-12-31',
        ]);

        DB::table('products_and_services_values')->insert([
            'products_and_services_id' => '3',
            'maximum_parcels' => '12',
            'value' => '330',
            'date_start' => '2020-03-01',
            'date_end' => '2021-12-31',
        ]);

        DB::table('products_and_services_values')->insert([
            'products_and_services_id' => '4',
            'maximum_parcels' => '12',
            'value' => '4000',
            'date_start' => '2020-03-01',
            'date_end' => '2021-12-31',
        ]);

    }
}
