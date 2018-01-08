<?php

use Illuminate\Database\Seeder;

class FakerProjectsSeeder extends Seeder
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
        $companiesIds = \App\Companies::all()->pluck('id')->toArray();
        $dealsIds = \App\Deals::all()->pluck('id')->toArray();
        $projectName = ['Geolides', 'noderston', 'ipader', 'KickSlider', 'maxim.safe', 'grunlog', 'ivier', 'easyntaxhl',
            'bbbles', 'abombl', 'yabbit', 'quireMobi', 'Redmondup', 'Typer', 'envil.it', 'kerbuildy', 'Audione', 'rotroll',
            'lighlight', 'Golias', 'Supernova'];

        for ($i = 0; $i<=20; $i++) {
            $projects = [
                'name' => $projectName[$i],
                'client_id' => $faker->randomElement($userIds),
                'companies_id' => $faker->randomElement($companiesIds),
                'deals_id' => $faker->randomElement($dealsIds),
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('projects')->insert($projects);
        }
    }
}
