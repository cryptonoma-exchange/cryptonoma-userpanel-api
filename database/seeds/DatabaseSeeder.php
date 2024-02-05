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
        $this->call(CountriesTableSeeder::class);
        $this->call(TradepairsTableSeeder::class);
        $this->call(CommissionsTableSeeder::class);
        $this->call(SocialMediaTableSeeder::class);
        $this->call(LogosTableSeeder::class);
        $this->call(FeaturesTableSeeder::class);
        $this->call(FaqsTableSeeder::class);
        $this->call(AdminbankdetailsTableSeeder::class);
        //$this->call(CMSTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(GeneralSettingsTableSeeder::class);
        
    }
}
