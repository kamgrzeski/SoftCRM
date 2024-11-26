<?php

namespace Database\Seeders;
use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class FakerClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::factory(30)->create();
    }
}
