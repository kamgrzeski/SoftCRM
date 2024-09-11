<?php

namespace App\Services;

use App\Queries\DealsQueries;
use App\Queries\FinancesQueries;
use App\Queries\ProductsQueries;
use App\Queries\SalesQueries;

class GraphDataService
{
    private int $width = 400;
    private int $height = 200;

    public function taskGraphData() {

        $cash = new CalculateCashService();

        return app()->chartjs
            ->name('taskGraphData')
            ->type('line')
            ->size(['width' => $this->width, 'height' => $this->height])
            ->labels(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])
            ->datasets([
                [
                    "label" => "Added tasks",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $cash->loadTaskEveryMonth(false)
                ],
                [
                    "label" => "Completed tasks",
                    'backgroundColor' => "rgba(38, 80, 186, 0.55)",
                    'borderColor' => "rgba(38, 80, 186, 1)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $cash->loadTaskEveryMonth(true)
                ]
            ])
            ->options([]);
    }

    /**
     * @return mixed
     */
    public function itemsCountGraphData() {
        return app()->chartjs
            ->name('cashTurnoverGraphData')
            ->type('bar')
            ->size(['width' => $this->width, 'height' => $this->height])
            ->datasets([
                [
                    "label" => "Products",
                    'backgroundColor' => ['rgba(227, 67, 51, 1)', 'rgba(54, 162, 235, 0.2)'],
                    'data' => [ProductsQueries::countAll()]
                ],
                [
                    "label" => "Sales",
                    'backgroundColor' => ['rgba(228, 115, 45, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [SalesQueries::countAll()]
                ],
                [
                    "label" => "Finances",
                    'backgroundColor' => ['rgba(249, 195, 100, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [FinancesQueries::countAll()]
                ],
                [
                    "label" => "Deal",
                    'backgroundColor' => ['rgba(92, 141, 93, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [DealsQueries::countAll()]
                ]
            ])
            ->options([]);
    }
}
