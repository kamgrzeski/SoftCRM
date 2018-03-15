<?php

use Illuminate\Database\Seeder;

class FakerCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $userIds = \App\Models\ClientsModel::all()->pluck('id')->toArray();
        $rowRand = rand(30,100);

        for ($i = 0; $i<$rowRand; $i++) {
            $companies = [
                'name' => $faker->company,
                'tax_number' => $faker->unixTime($max = 'now'),
                'phone' => $faker->phoneNumber,
                'city' => $faker->city,
                'billing_address' => $faker->streetAddress,
                'country' => $faker->country,
                'postal_code' => $faker->postcode,
                'employees_size' => rand(100,1000),
                'fax' => $faker->phoneNumber,
                'description' => $faker->text($maxNbChars = 200),
                'client_id' => $faker->randomElement($userIds),
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('companies')->insert($companies);
        }
    }
}
