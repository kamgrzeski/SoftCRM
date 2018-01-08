<?php

use Illuminate\Database\Seeder;

class FakerFinancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $companiesIds = \App\Companies::all()->pluck('id')->toArray();
        $rowRand = rand(30,100);

        for ($i = 0; $i<$rowRand; $i++) {
            $finances = [
                'name' => $faker->name,
                'companies_id' => $faker->randomElement($companiesIds),
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('finances')->insert($finances);
        }
    }
}
