<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //pagination_size
        DB::table('settings')->insert(
            [
                'key' => 'pagination_size',
                'value' => 5,
                'description' => 'set pagination size',
                'created_at' => now(),
            ]
        );

        //currency
        DB::table('settings')->insert(
            [
                'key' => 'currency',
                'value' => 'EUR',
                'description' => 'set currency type',
                'created_at' => now(),
            ]
        );

        //priority_size
        DB::table('settings')->insert(
            [
                'key' => 'priority_size',
                'value' => 3,
                'description' => 'set priority size',
                'created_at' => now(),
            ]
        );

        //invoice_tax
        DB::table('settings')->insert(
            [
                'key' => 'invoice_tax',
                'value' => 3,
                'description' => 'set invoice tax size',
                'created_at' => now(),
            ]
        );

        //invoice_tax
        DB::table('settings')->insert(
            [
                'key' => 'invoice_tax',
                'value' => 3,
                'description' => 'set invoice tax size',
                'created_at' => now(),
            ]
        );

        //loading_circle
        DB::table('settings')->insert(
            [
                'key' => 'loading_circle',
                'value' => 1,
                'description' => 'set loading circle',
                'created_at' => now(),
            ]
        );

        // last deploy time
        DB::table('settings')->insert(
            [
                'key' => 'last_deploy_time',
                'value' => now(),
                'description' => 'set last deploy time',
                'is_visible' => false,
                'created_at' => now(),
            ]
        );

        // last deploy version
        DB::table('settings')->insert(
            [
                'key' => 'last_deploy_version',
                'value' => '1.0.0',
                'description' => 'set last deploy version',
                'is_visible' => false,
                'created_at' => now(),
            ]
        );
    }
}
