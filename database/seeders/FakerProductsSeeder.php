<?php

namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Seeder;

class FakerProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory(10)->create();
    }
}
