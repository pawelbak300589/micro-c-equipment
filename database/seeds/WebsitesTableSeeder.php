<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $websites = [
            ['name' => 'AlpinTrek', 'url' => 'https://www.alpinetrek.co.uk/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'ClimbersShop', 'url' => 'https://www.climbers-shop.com/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'RockRun', 'url' => 'https://rockrun.com/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'TrekkInn', 'url' => 'https://www.trekkinn.com/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'WeighMyRack', 'url' => 'https://blog.weighmyrack.com/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Decathlon', 'url' => 'https://www.decathlon.co.uk/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'CotswoldOutdoor', 'url' => 'https://www.cotswoldoutdoor.com/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'EllisBrigham', 'url' => 'https://www.ellis-brigham.com/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'GoOutdoors', 'url' => 'https://www.gooutdoors.co.uk/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'BananaFingers', 'url' => 'https://www.bananafingers.co.uk/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'TheClimbingDepot', 'url' => 'https://www.theclimbingdepot.co.uk/shop', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'DicksClimbing', 'url' => 'https://www.dicksclimbing.com/', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];
        DB::table('websites')->insert($websites);
    }
}
