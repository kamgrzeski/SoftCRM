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
        $userIds = \App\Models\ClientsModel::all()->pluck('id')->toArray();
        $employeeIds = \App\Models\EmployeesModel::all()->pluck('id')->toArray();
        $rowRand = rand(30,100);

        for ($i = 0; $i<$rowRand; $i++) {
            $contacts = [
                'client_id' => $faker->randomElement($userIds),
                'employee_id' => $faker->randomElement($employeeIds),
                'date' => $faker->date,
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('contacts')->insert($contacts);
        }
    }
}
