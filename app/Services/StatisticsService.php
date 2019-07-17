<?php

namespace App\Services;

use App\Models\FinancesModel;
use App\Models\ProductsModel;
use App\Models\SalesModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Money\Money;

class StatisticsService
{
    public function countAllRowsInDb()
    {
        $counter = 0;
        $tables = array_map('reset', \DB::select('SHOW TABLES'));

        foreach ($tables as $table) {
            $counter += DB::table($table)->count();
        }

        return $counter;
    }

    public function countCashTurnover()
    {
        $products = ProductsModel::all();
        $sales = SalesModel::all();
        $finances = FinancesModel::all();

        $productSum = 0;
        $salesSum = 0;
        $financesSum = 0;

        foreach($products as $product) {
            $productSum += $product->price * $product->count;
            foreach($sales as $sale) {
                $salesSum += $product->price * $sale->quantity;
            }
            foreach($finances as $finance) {
                $financesSum += $finance->net;
            }
        }

        $officialSum = $productSum + $salesSum + $financesSum;

        return $officialSum;
    }

    public function countYesterdayIncome()
    {
        $products = ProductsModel::whereDate('created_at', Carbon::yesterday())->get();
        $sales = SalesModel::whereDate('created_at', Carbon::yesterday())->get();
        $finances = FinancesModel::whereDate('created_at', Carbon::yesterday())->get();
        $salesSum = 0;
        $productSum = 0;
        $financesSum = 0;

        foreach($products as $product) {
            $productSum += $product->price * $product->count;
            foreach($sales as $sale) {
                $salesSum += $product->price * $sale->quantity;
            }
            foreach($finances as $finance) {
                $financesSum += $finance->net;
            }
        }

        $yesterdayIncome = $productSum + $salesSum + $financesSum;

        return $yesterdayIncome;
    }

    public function countTodayIncome()
    {
        $products = ProductsModel::whereDate('created_at', Carbon::today())->get();
        $sales = SalesModel::whereDate('created_at', Carbon::today())->get();
        $finances = FinancesModel::whereDate('created_at', Carbon::today())->get();
        $productSum = 0;
        $salesSum = 0;
        $financesSum = 0;

        foreach($products as $product) {
            $productSum += $product->price * $product->count;
            foreach($sales as $sale) {
                $salesSum += $product->price * $sale->quantity;
            }
            foreach($finances as $finance) {
                $financesSum += $finance->net;
            }
        }

        $todayIncome = $productSum + $salesSum + $financesSum;

        return $todayIncome;
    }
}