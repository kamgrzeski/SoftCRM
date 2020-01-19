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
                'description' => 'set pagination size'
            ]
        );

        //currency
        DB::table('settings')->insert(
            [
                'key' => 'currency',
                'value' => 'EUR',
                'description' => 'set currency type'
            ]
        );

        //priority_size
        DB::table('settings')->insert(
            [
                'key' => 'priority_size',
                'value' => 3,
                'description' => 'set priority size'
            ]
        );

        //invoice_tax
        DB::table('settings')->insert(
            [
                'key' => 'invoice_tax',
                'value' => 3,
                'description' => 'set invoice tax size'
            ]
        );

        //invoice_tax
        DB::table('settings')->insert(
            [
                'key' => 'invoice_tax',
                'value' => 3,
                'description' => 'set invoice tax size'
            ]
        );

        //loading_circle
        DB::table('settings')->insert(
            [
                'key' => 'loading_circle',
                'value' => 1,
                'description' => 'set loading circle'
            ]
        );
    }
}
