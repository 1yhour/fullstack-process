<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(10)->create();
        Product::create(
            [
                'name' => 'Welcome Coupon',
                'price' => 100,
                'category_id' => 2,
                'user_id' => 1,
            ]
        );
    }   
}
