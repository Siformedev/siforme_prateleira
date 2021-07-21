<?php

use Illuminate\Database\Seeder;

class ContractsCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_course')->insert([
            'contract_id' => '1',
            'course_id' => '1',
        ]);
    }
}
