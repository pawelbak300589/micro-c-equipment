<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            'name' => 'Petzl',
            'description' => 'Petzl description',
            'website' => 'https://www.petzl.com/GB/en/Sport',
        ]);
    }
}
