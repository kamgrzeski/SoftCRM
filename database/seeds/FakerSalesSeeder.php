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
        $rowRand = rand(30,100);

        for ($i = 0; $i<$rowRand; $i++) {
            $sales = [
                'name' => $faker->userName,
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('sales')->insert($sales);
        }
    }
}
