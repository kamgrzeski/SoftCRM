<?php

namespace Database\Seeders;

use App\Models\Finance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class FakerFinancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Finance::factory()->count(10)->create();
    }
}
