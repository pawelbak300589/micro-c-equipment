<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Category::class)->create([
            'id' => 1,
            'website_id' => 1,
            'name' => 'Default Category',
            'url' => 'http://default.com',
        ]);
    }
}
