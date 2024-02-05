<?php

use Illuminate\Database\Seeder;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('features')->insert(
        [
            'heading' => 'EXCHANGE',
            'desc' => 'We operate the advanced blockchain exchange platform, which is designed for users who demand secure exchange execution.',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);

          DB::table('features')->insert(
        [
            'heading' => 'EASY TO USE',
            'desc' => 'We make getting into your assets easy with simple tools. Choose the cryptocurrency you would like to exchange, and then input your receiving address and amount.',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);


            DB::table('features')->insert(
        [
            'heading' => 'SECURE',
            'desc' => 'Security will always be a top priority in every decision we make, and we provides a safe, reliable and stable environment for digital assets exchange by advanced technologies.',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),     
        ]);
    }
}
