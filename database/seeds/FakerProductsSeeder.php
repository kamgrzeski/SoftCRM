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
        $names = ['Photo camera', 'Underwear', 'Hoodie', 'Boots', 'Handkerchiefs', 'Wet wipes', 'Pen', 'Comb',
            'Food from the fridge', 'Card', 'Compass', 'GOT books', 'Slippers', 'Keys from the apartment', 'Cream',
            'Binoculars', 'Maps','beverages', 'Band', 'Toothpaste', 'Cape', 'Undershirt', 'Wallet', 'Snacks on the road',
            'Towel', 'Gloves', 'Socks', 'Trousers', 'Shampoo', 'Brush', 'Sleeping bag', 'Phone', 'Bags','Shower gel'];

        for ($i = 0; $i<=30; $i++) {
            $products = [
                'name' => $names[$i],
                'category' => $faker->lastName,
                'count' => rand(50,500),
                'price' => rand(10,1000),
                'created_at' => $faker->dateTimeBetween($startDate = '-'.$i.' days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('products')->insert($products);
        }
    }
}
