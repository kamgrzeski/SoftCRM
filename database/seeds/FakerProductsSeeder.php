<?php

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
        $faker = \Faker\Factory::create();
        $rowRand = rand(30,100);

        for ($i = 0; $i<$rowRand; $i++) {
            $products = [
                'name' => $faker->name,
                'category' => $faker->lastName,
                'count' => $faker->buildingNumber,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('products')->insert($products);
        }
    }
}
