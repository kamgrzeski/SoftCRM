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
                'name' => $faker->name,
                'employee_id' => $faker->randomElement($employeeIds),
                'completed' => 0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('tasks')->insert($tasks);
        }
    }
}
