<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsTableSeeder extends Seeder
{
    public function run()
    {
        $colors = [
            ['name' => 'Red', 'name_ar' => 'أحمر', 'value' => '#FF0000'],
            ['name' => 'Green', 'name_ar' => 'أخضر', 'value' => '#00FF00'],
            ['name' => 'Blue', 'name_ar' => 'أزرق', 'value' => '#0000FF'],
            ['name' => 'Black', 'name_ar' => 'أسود', 'value' => '#000000'],
            ['name' => 'White', 'name_ar' => 'أبيض', 'value' => '#FFFFFF'],
            ['name' => 'Yellow', 'name_ar' => 'أصفر', 'value' => '#FFFF00'],
            ['name' => 'Purple', 'name_ar' => 'بنفسجي', 'value' => '#800080'],
            ['name' => 'Orange', 'name_ar' => 'برتقالي', 'value' => '#FFA500'],
            ['name' => 'Pink', 'name_ar' => 'وردي', 'value' => '#FFC0CB'],
            ['name' => 'Gray', 'name_ar' => 'رمادي', 'value' => '#808080'],
            ['name' => 'Brown', 'name_ar' => 'بني', 'value' => '#A52A2A'],
            ['name' => 'Cyan', 'name_ar' => 'سماوي', 'value' => '#00FFFF'],
            ['name' => 'Magenta', 'name_ar' => 'أرجواني', 'value' => '#FF00FF'],
            ['name' => 'Teal', 'name_ar' => 'أزرق مخضر', 'value' => '#008080'],
            ['name' => 'Lime', 'name_ar' => 'ليموني', 'value' => '#BFFF00'],
            ['name' => 'Maroon', 'name_ar' => 'كستنائي', 'value' => '#800000'],
            ['name' => 'Navy', 'name_ar' => 'كحلي', 'value' => '#000080'],
        ];

        DB::table('colors')->insert($colors);
    }
}
