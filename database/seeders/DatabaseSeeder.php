<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Llama al seeder del usuario
        $this->call(UserSeeder::class);
        // Crea categorías y producto
        Category::factory(5)->create()->each(function ($category) {
            Product::factory(3)->create([
                'category_id' => $category->id,
            ]);
        });
    }
}