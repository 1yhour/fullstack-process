<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                "category_name"=>"Electronics"
            ],
            [
                "category_name"=>"Clothing"
            ],
            [
                "category_name"=>"Food"
            ]
        ];
        foreach($categories as $cat){
            Category::create($cat);
        }
    }
}
