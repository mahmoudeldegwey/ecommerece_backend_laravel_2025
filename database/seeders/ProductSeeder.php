<?php
namespace Database\Seeders;


use App\Models\{Category,Image,Size,Color,Product,Brand};

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $colorIds = Color::pluck('id')->toArray();
        $sizeIds = Size::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();
        $brandIds = Brand::pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            $product = Product::create([
                'name' => $faker->words(3, true),
                'name_ar' => 'منتج ' . $index,
                'description' => $faker->paragraph,
                'description_ar' => 'وصف المنتج ' . $index,
                'seo_title' => $faker->sentence,
                'seo_description' => $faker->text(160),
                'price' => $faker->randomFloat(2, 100, 1000),
                'sale_price' => $faker->optional()->randomFloat(2, 50, 900),
                'quantity' => $faker->numberBetween(1, 100),
                'main_image' => 'https://placehold.co/600x600.png?text=Product+' . $index,
                'has_free_shipping' => $faker->boolean,
                'has_multi_color' => $faker->boolean,
                'has_multi_size' => $faker->boolean,
                'brand_id' => $faker->randomElement($brandIds),
                'sku' => strtoupper(Str::random(8)),
            ]);

            // 2. Attach random colors
            $product->colors()->attach($faker->randomElements($colorIds));

            // 3. Attach random sizes
            $product->sizes()->attach($faker->randomElements($sizeIds));

            // 4. Attach random categories
            $product->categories()->attach($faker->randomElements($categoryIds));

            // 5. Add multiple images
            foreach (range(1, rand(2, 4)) as $imgIndex) {
                $product->images()->create([
                    'model_type' => Product::class,
                    'url' => "https://placehold.co/600x600.png?text=Image+{$index}_{$imgIndex}",
                    'name' => 'Product Image ' . $imgIndex,
                    'extension' => 'png'
                ]);
            }
        }
    }
}
