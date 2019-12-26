<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminAccSeeder::class);
        $this->call(FakerClientSeeder::class);
        $this->call(FakerCompaniesSeeder::class);
        $this->call(FakerEmployeesSeeder::class);
        $this->call(FakerDealsSeeder::class);
        $this->call(FakerProductsSeeder::class);
        $this->call(FakerSalesSeeder::class);
        $this->call(FakerTasksSeeder::class);
        $this->call(FakerFinancesSeeder::class);

    }
}
