<?php

use Illuminate\Database\Seeder;

class FakerContactsSeeder extends Seeder
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
        $employeeIds = \App\Employees::all()->pluck('id')->toArray();
        $rowRand = rand(30,100);

        for ($i = 0; $i<$rowRand; $i++) {
            $contacts = [
                'client_id' => $faker->randomElement($userIds),
                'employee_id' => $faker->randomElement($employeeIds),
                'date' => $faker->date,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('contacts')->insert($contacts);
        }
    }
}
