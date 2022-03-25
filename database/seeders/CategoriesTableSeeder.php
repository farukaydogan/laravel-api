<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('categories')->truncate();
        // Category::truncate();
        Category::factory(100)->create();

        DB::table('product_categories')->insert(['product_id' => 1, 'category_id' => 1]);
        DB::table('product_categories')->insert(['product_id' => 1, 'category_id' => 2]);
        DB::table('product_categories')->insert(['product_id' => 2, 'category_id' => 1]);
        DB::table('product_categories')->insert(['product_id' => 2, 'category_id' => 2]);
        DB::table('product_categories')->insert(['product_id' => 2, 'category_id' => 3]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
