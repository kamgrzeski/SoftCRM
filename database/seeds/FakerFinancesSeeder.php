<?php

use Illuminate\Database\Seeder;

class FakerFinancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $companiesIds = \App\Models\CompaniesModel::all()->pluck('id')->toArray();
        $rowRand = rand(30,70);
        $category = ['steady income', 'large order', 'small order', 'one-off order'];
        $type = ['Invoice', 'proforma invoice', 'advance', 'simple transfer'];

        for ($i = 0; $i<$rowRand; $i++) {
            $rand = rand(800,2000);
            $calculateFromFakeRand = new \App\Services\FinancesService();

            $data = $calculateFromFakeRand->calculateNetAndVatByGivenGross($rand);

            $finances = [
                'name' => $faker->name,
                'description' => $faker->text(100),
                'category' => array_random($category),
                'type' => array_random($type),
                'gross' => $rand,
                'vat' => $data['vat'],
                'net' => $data['net'],
                'date' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'companies_id' => $faker->randomElement($companiesIds),
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now'),
                'updated_at' => \Carbon\Carbon::now()
            ];

            DB::table('finances')->insert($finances);
        }
    }
}
