<?php

namespace Database\Seeders;

use App\Models\FiasLevelCode;
use Illuminate\Database\Seeder;

class FiasLevelCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(FiasLevelCode $code)
    {
        $levels = [
            ['fias_title' => 'уровень региона', 'fias_code' => 1, 'slug' => 'region', 'name' => 'регион'],
            ['fias_title' => 'уровень района', 'fias_code' => 3, 'slug' => 'district', 'name' => 'район'],
            ['fias_title' => 'уровень городских и сельских поселений', 'fias_code' => 35, 'slug' => 'region', 'name' => 'городские и сельские поселения'],
            ['fias_title' => 'уровень города', 'fias_code' => 4, 'slug' => 'city', 'name' => 'город'],
            ['fias_title' => 'уровень населенного пункта', 'fias_code' => 6, 'slug' => 'locality', 'name' => 'населенный пункт'],
            ['fias_title' => 'земельный участок', 'fias_code' => 75, 'slug' => 'stead', 'name' => 'земельный участок'],
            ['fias_title' => 'здания, сооружения, объекта незавершенного строительства', 'fias_code' => 8, 'slug' => 'house', 'name' => 'дом'],
        ];
        $code::insert($levels);
    }
}
