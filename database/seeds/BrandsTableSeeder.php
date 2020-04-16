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
        factory(App\Brand::class)->create([
            'id' => 1,
            'name' => 'Default Brand',
            'url' => 'http://default.com',
            'img' => 'http://default.com/image.png',
        ]);
    }
}
