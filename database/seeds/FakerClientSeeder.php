<?php

use Illuminate\Database\Seeder;

class FakerClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $section = ['transport', 'logistic', 'finances'];

        for ($i = 0; $i<=30; $i++) {
            $client = [
                'full_name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->companyEmail,
                'section' => array_random($section),
                'budget' => rand(100, 1000),
                'location' => $faker->country,
                'zip' => $faker->postcode,
                'city' => $faker->city,
                'country' => $faker->country,
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now()
            ];

             DB::table('clients')->insert($client);
        }
    }
}
