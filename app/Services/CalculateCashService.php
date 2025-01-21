<?php

namespace App\Services;

use App\Models\Finance;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Task;
use App\Queries\SettingQueries;
use Carbon\Carbon;
use Cknow\Money\Money;
use Illuminate\Support\Facades\DB;

class CalculateCashService
{
    /**
     * @return mixed
     */
    public function loadCountCashTurnover(): mixed
    {
        $productSum = Product::get()
            ->sum(function ($product) {
                return $product->price * $product->count;
            });

        $salesSum = Sale::get()
            ->sum(function ($sale) {
                return $sale->price * $sale->quantity;
            });

        $financesSum = Finance::sum('net');

        $officialSum = $productSum + $salesSum + $financesSum;

        return Money::{SettingQueries::getSettingValue('currency')}($officialSum);
    }

    /**
     * @return mixed
     */
    public function loadCountTodayIncome(): mixed
    {
        $productSum = Product::whereDate('created_at', Carbon::today())
            ->get()
            ->sum(function ($product) {
                return $product->price * $product->count;
            });

        $salesSum = Sale::whereDate('created_at', Carbon::today())
            ->get()
            ->sum(function ($sale) {
                return $sale->price * $sale->quantity;
            });

        $financesSum = Finance::whereDate('created_at', Carbon::today())->sum('net');

        $todayIncome = $productSum + $salesSum + $financesSum;

        return Money::{SettingQueries::getSettingValue('currency')}($todayIncome);
    }

    /**
     * @return mixed
     */
    public function loadCountYesterdayIncome(): mixed
    {
        $productSum = Product::whereDate('created_at', Carbon::yesterday())
            ->get()
            ->sum(function ($product) {
                return $product->price * $product->count;
            });

        $salesSum = Sale::whereDate('created_at', Carbon::yesterday())
            ->get()
            ->sum(function ($sale) {
                return $sale->price * $sale->quantity;
            });

        $financesSum = Finance::whereDate('created_at', Carbon::yesterday())->sum('net');

        $yesterdayIncome = $productSum + $salesSum + $financesSum;

        return Money::{SettingQueries::getSettingValue('currency')}($yesterdayIncome);
    }

    /**
     * @return int
     */
    public function loadCountAllRowsInDb(): int
    {
        $counter = 0;
        $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");

        foreach ($tables as $table) {
            $tableName = $table->name;
            $counter += DB::table($tableName)->count();
        }

        return $counter;
    }

    public function loadTaskEveryMonth(bool $isCompleted): array
    {
        $dates = collect();
        foreach (range(-6, 0) as $i) {
            $date = Carbon::now()->addDays($i)->format('Y-m-d');
            $dates->put($date, 0);
        }

        $query = Task::where('created_at', '>=', $dates->keys()->first())
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('created_at');

        if ($isCompleted) {
            $query->where('completed', 1);
        }

        $posts = $query->get([
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as "count"')
        ])->pluck('count', 'date');

        // Merge posts data with the default zeroed dates
        $dates = $dates->merge($posts);

        return $dates->values()->toArray();
    }
}
