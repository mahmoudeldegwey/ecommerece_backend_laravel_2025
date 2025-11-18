<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countryId = 1; // Egypt

        $cities = [
            ['name' => 'Cairo', 'name_ar' => 'القاهرة', 'code' => 'CAI', 'shipping_cost' => 50, 'postal_code' => '11511'],
            ['name' => 'Giza', 'name_ar' => 'الجيزة', 'code' => 'GIZ', 'shipping_cost' => 45, 'postal_code' => '12511'],
            ['name' => 'Alexandria', 'name_ar' => 'الإسكندرية', 'code' => 'ALX', 'shipping_cost' => 55, 'postal_code' => '21532'],
            ['name' => 'Dakahlia', 'name_ar' => 'الدقهلية', 'code' => 'DAK', 'shipping_cost' => 60, 'postal_code' => '35711'],
            ['name' => 'Sharqia', 'name_ar' => 'الشرقية', 'code' => 'SHQ', 'shipping_cost' => 60, 'postal_code' => '44511'],
            ['name' => 'Qalyubia', 'name_ar' => 'القليوبية', 'code' => 'QLY', 'shipping_cost' => 58, 'postal_code' => '13632'],
            ['name' => 'Gharbia', 'name_ar' => 'الغربية', 'code' => 'GHB', 'shipping_cost' => 62, 'postal_code' => '31511'],
            ['name' => 'Monufia', 'name_ar' => 'المنوفية', 'code' => 'MNF', 'shipping_cost' => 57, 'postal_code' => '32511'],
            ['name' => 'Beheira', 'name_ar' => 'البحيرة', 'code' => 'BEH', 'shipping_cost' => 64, 'postal_code' => '81657'],
            ['name' => 'Kafr El Sheikh', 'name_ar' => 'كفر الشيخ', 'code' => 'KFS', 'shipping_cost' => 66, 'postal_code' => '33511'],
            ['name' => 'Fayoum', 'name_ar' => 'الفيوم', 'code' => 'FYM', 'shipping_cost' => 53, 'postal_code' => '63511'],
            ['name' => 'Beni Suef', 'name_ar' => 'بني سويف', 'code' => 'BSF', 'shipping_cost' => 52, 'postal_code' => '62511'],
            ['name' => 'Minya', 'name_ar' => 'المنيا', 'code' => 'MIN', 'shipping_cost' => 70, 'postal_code' => '61511'],
            ['name' => 'Assiut', 'name_ar' => 'أسيوط', 'code' => 'AST', 'shipping_cost' => 75, 'postal_code' => '71511'],
            ['name' => 'Sohag', 'name_ar' => 'سوهاج', 'code' => 'SHG', 'shipping_cost' => 80, 'postal_code' => '82511'],
            ['name' => 'Qena', 'name_ar' => 'قنا', 'code' => 'QNA', 'shipping_cost' => 82, 'postal_code' => '83511'],
            ['name' => 'Luxor', 'name_ar' => 'الأقصر', 'code' => 'LXR', 'shipping_cost' => 85, 'postal_code' => '85951'],
            ['name' => 'Aswan', 'name_ar' => 'أسوان', 'code' => 'ASN', 'shipping_cost' => 90, 'postal_code' => '81511'],
            ['name' => 'Red Sea', 'name_ar' => 'البحر الأحمر', 'code' => 'RDH', 'shipping_cost' => 95, 'postal_code' => '84511'],
            ['name' => 'South Sinai', 'name_ar' => 'جنوب سيناء', 'code' => 'SIN', 'shipping_cost' => 100, 'postal_code' => '46611'],
            ['name' => 'North Sinai', 'name_ar' => 'شمال سيناء', 'code' => 'NSN', 'shipping_cost' => 100, 'postal_code' => '45511'],
            ['name' => 'Matruh', 'name_ar' => 'مطروح', 'code' => 'MTR', 'shipping_cost' => 100, 'postal_code' => '51511'],
            ['name' => 'New Valley', 'name_ar' => 'الوادي الجديد', 'code' => 'NVL', 'shipping_cost' => 105, 'postal_code' => '72511'],
            ['name' => 'Damietta', 'name_ar' => 'دمياط', 'code' => 'DMY', 'shipping_cost' => 60, 'postal_code' => '34511'],
            ['name' => 'Ismailia', 'name_ar' => 'الإسماعيلية', 'code' => 'ISM', 'shipping_cost' => 58, 'postal_code' => '41511'],
            ['name' => 'Suez', 'name_ar' => 'السويس', 'code' => 'SUZ', 'shipping_cost' => 60, 'postal_code' => '43511'],
            ['name' => 'Port Said', 'name_ar' => 'بورسعيد', 'code' => 'PSD', 'shipping_cost' => 63, 'postal_code' => '42511'],
        ];
        
        $data = [];

        foreach ($cities as $city) {
            $data[] = array_merge($city, ['country_id' => $countryId]);
        }

        City::insert($data);
    }
}
