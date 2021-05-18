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
                'description' => 'test description',
                'client_id' => $userIds[array_rand($userIds)],
                'created_at' => \Carbon\Carbon::now()->subDays(rand(1, 33)),
                'updated_at' => \Carbon\Carbon::now(),
                'admin_id' => 1
            ];

            DB::table('companies')->insert($companies);
        }
    }
}
