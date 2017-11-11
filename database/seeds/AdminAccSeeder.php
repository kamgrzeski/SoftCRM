<?php

use Illuminate\Database\Seeder;

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

        return DB::table('users')->insert($user);
    }
}
