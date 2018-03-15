<?php

use Illuminate\Database\Seeder;

class FakerSalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
//        $productDetails = \App\Models\ProductsModel::where('id', '=', $productId)->get();
        $productDetails = \App\Models\ProductsModel::all();

            foreach($productDetails as $detail) {
                $sales = [
                    'name' => $faker->name,
                    'quantity' => rand(10,20),
                    'product_id' => $detail->id,
                    'date_of_payment' => $faker->dateTimeThisMonth(),
                    'price' => $detail->price, //update this manual
                    'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                    'updated_at' => \Carbon\Carbon::now()
                ];

                DB::table('sales')->insert($sales);
            }
        }
}
