<?php

use Illuminate\Database\Seeder;

class FakerTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $employeeIds = \App\Employees::all()->pluck('id')->toArray();
        $rowRand = rand(30,100);

        for ($i = 0; $i<$rowRand; $i++) {
            $tasks = [
                'name' => $faker->text($maxNbChars = 200),
                'employee_id' => $faker->randomElement($employeeIds),
                'duration' => rand(1,30),
                'completed' => 0,
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('tasks')->insert($tasks);
        }
    }
}
