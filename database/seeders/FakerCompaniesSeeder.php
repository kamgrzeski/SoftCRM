<?php

namespace Database\Seeders;

use App\Models\Company;
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
        $userIds = \App\Models\Client::all()->pluck('id')->toArray();

        Company::factory(10)->create([
            'client_id' => function() use ($userIds) {
                return $userIds[array_rand($userIds)];
            }
        ]);
    }
}
