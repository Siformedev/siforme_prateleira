<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ContractsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(CategoriasProdutosEServicosSeeder::class);
        $this->call(CategoriasTiposSeeder::class);
        $this->call(ProductsAndServicesTableSeeder::class);
        $this->call(ProductsAndServicesValuesTableSeeder::class);
        $this->call(ProductsAndServicesDiscountsTableSeeder::class);
        $this->call(ContractsCoursesTableSeeder::class);
        $this->call(ProdutosEServicosTermosTableSeeder::class);
        $this->call(AccountPseg::class);
    }
}
