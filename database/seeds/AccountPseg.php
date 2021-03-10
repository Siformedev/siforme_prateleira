<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AccountPseg extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //id=1
        DB::table('account_pseg')->insert([
            'app_pseg_id' => 'gticket',
            'app_pseg_key' => 'D92E468160608C25545A9F9BA0C1EE59',
            'app_pseg_auth' => 'BA16E62CFA3C4299B832ECEE00083F2D',
            'pseg_email' => 'adalbertoandreoli@gmail.com',
            'pseg_token' => 'bdbea60c-c735-4c4d-93f7-4f2f072e68c2a74b05014b9d86b0befa8ece89ed214bfdeb-022a-48b1-bc13-79c9a48a916f',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('account_pseg')->insert([
            'app_pseg_id' => 'gticket',
            'app_pseg_key' => 'D92E468160608C25545A9F9BA0C1EE59',
            'app_pseg_auth' => 'F77047E14453483DB03D38FAD36B9E46',
            'pseg_email' => 'lescoderbr@gmail.com',
            'pseg_token' => 'a9a1dcdf-fa13-4631-86ef-65b2b095e1a41298a73a47d4b5ff63a40fe14928ea183130-64cb-4449-9e65-b8d716a8b41f',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('account_pseg')->insert([
            'app_pseg_id' => 'gticket',
            'app_pseg_key' => 'D92E468160608C25545A9F9BA0C1EE59',
            'app_pseg_auth' => 'F0610E837CAF469E90CF79394FB169F2',
            'pseg_email' => 'financeiro@easyticket.com.br',
            'pseg_token' => '281e9b60-231b-47f6-b993-8413db15c681f064224d410d94c9d19d54d55bfe26a64d21-e2e8-4ec6-a600-8cfabb1159a3',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('account_pseg')->insert([
            'app_pseg_id' => 'gticket',
            'app_pseg_key' => 'D92E468160608C25545A9F9BA0C1EE59',
            'app_pseg_auth' => 'EF5260D52C674BCDA886566903FF17B2',
            'pseg_email' => 'contato@ticketei.com.br',
            'pseg_token' => '92008dc8-b2cc-4324-a9ca-3affc9d042b4ac58bb794ffc87c2b6b85b9a6b2a39a644ad-1e1b-4a47-a15b-f6a2c7a694a1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
