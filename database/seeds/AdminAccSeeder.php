<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminAccSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = ['name' => 'admin','email' => 'admin@admin.com','password' => bcrypt('admin')];

        DB::table('users')->insert($user);
    }
}
