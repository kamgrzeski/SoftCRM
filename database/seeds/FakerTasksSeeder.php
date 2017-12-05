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
        $date = \Carbon\Carbon::create(2015, 5, 28, 0, 0, 0);

        for ($i = 0; $i<$rowRand; $i++) {
            $tasks = [
                'name' => $faker->text($maxNbChars = 200),
                'employee_id' => $faker->randomElement($employeeIds),
                'completed' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('tasks')->insert($tasks);
        }
    }
}
