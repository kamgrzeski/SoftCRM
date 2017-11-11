<?php

use Illuminate\Database\Seeder;

class FakerEmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $userIds = \App\Client::all()->pluck('id')->toArray();
        $rowRand = rand(30,100);

        for ($i = 0; $i<$rowRand; $i++) {
            $employees = [
                'full_name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'job' => $faker->email,
                'note' => $faker->uuid,
                'client_id' => $faker->randomElement($userIds),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('employees')->insert($employees);
        }
    }
}
