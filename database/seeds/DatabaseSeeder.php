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
        $this->call('WebsitesTableSeeder');
        $this->call('BrandsTableSeeder');
        $this->call('CategoriesTableSeeder');
        $this->call('GearsTableSeeder');
    }
}
