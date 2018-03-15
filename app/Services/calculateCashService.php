<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 15.03.2018
 * Time: 09:20
 */

namespace App\Services;

use App\Products;
use App\Tasks;
use Carbon\Carbon;
use ClickNow\Money\Money;
use Illuminate\Support\Facades\DB;

class CalculateCashService
{
    /**
     * @return mixed
     */
    public function countCashTurnover()
    {
        $products = Products::all();
        $productSum = 0;

        foreach($products as $product) {
            $productSum += $product->price * $product->count;
        }

        $oficialSum = $productSum;

        return Money::{config('crm_settings.currency')}($oficialSum);
    }

    /**
     * @return mixed
     */
    public function countTodayIncome()
    {
        $products = Products::whereDate('created_at', Carbon::today())->get();
        $productSum = 0;

        foreach($products as $product) {
            $productSum += $product->price * $product->count;
        }

        $todayIncome = $productSum;

        return Money::{config('crm_settings.currency')}($todayIncome);
    }

    /**
     * @return mixed
     */
    public function countYesterdayIncome()
    {
        $products = Products::whereDate('created_at', Carbon::yesterday())->get();
        $productSum = 0;

        foreach($products as $product) {
            $productSum += $product->price * $product->count;
        }

        $yesterdayIncome = $productSum;

        return Money::{config('crm_settings.currency')}($yesterdayIncome);
    }

    /**
     * @return int
     */
    public function countAllRowsInDb()
    {
        $counter = 0;
        $tables = array_map('reset', \DB::select('SHOW TABLES'));

        foreach ($tables as $table) {
            $counter += DB::table($table)->count();
        }

        return $counter;
    }

    /**
     * @param $isCompleted
     * @return array
     */
    public function calculateTaskEveryMonth($isCompleted) {

        $dates = collect();
        foreach( range( -6, 0 ) AS $i ) {
            $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
            $dates->put( $date, 0);
        }

        if($isCompleted) {
            $posts = Tasks::where( 'created_at', '>=', $dates->keys()->first() )->where('completed', '=', 1)
                ->groupBy( 'date' )
                ->orderBy( 'date' )
                ->get( [
                    DB::raw( 'DATE( created_at ) as date' ),
                    DB::raw( 'COUNT( * ) as "count"' )
                ] )
                ->pluck( 'count', 'date' );
        } else {
            $posts = Tasks::where( 'created_at', '>=', $dates->keys()->first() )
                ->groupBy( 'date' )
                ->orderBy( 'date' )
                ->get( [
                    DB::raw( 'DATE( created_at ) as date' ),
                    DB::raw( 'COUNT( * ) as "count"' )
                ] )
                ->pluck( 'count', 'date' );
        }

        $dates = $dates->merge( $posts )->toArray();

        return array_values($dates);
    }
}