<?php
/**
 * Created by PhpStorm.
 * User: kamilgrzechulski
 * Date: 15.03.2018
 * Time: 09:20
 */

namespace App\Services;

use App\Deals;
use App\Finances;
use App\Products;
use App\Projects;
use App\Sales;
use App\Services;

class graphDataService
{
    public function taskGraphData() {

        $cash = new calculateCashService();

        if($cash) {
            $taskGraphData = app()->chartjs
                ->name('taskGraphData')
                ->type('line')
                ->size(['width' => 400, 'height' => 200])
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
                        'data' => $cash->calculateTaskEveryMonth($isCompleted = false)
                    ],
                    [
                        "label" => "Completed tasks",
                        'backgroundColor' => "rgba(38, 80, 186, 0.55)",
                        'borderColor' => "rgba(38, 80, 186, 1)",
                        "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                        "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                        "pointHoverBackgroundColor" => "#fff",
                        "pointHoverBorderColor" => "rgba(220,220,220,1)",
                        'data' => $cash->calculateTaskEveryMonth($isCompleted = true)
                    ]
                ])
                ->options([]);

            return $taskGraphData;
        }

        return false;
    }

    public function itemsCountGraphData() {
        $itemsCountGraphData = app()->chartjs
            ->name('cashTurnoverGraphData')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->datasets([
                [
                    "label" => "Products",
                    'backgroundColor' => ['rgba(227, 67, 51, 1)', 'rgba(54, 162, 235, 0.2)'],
                    'data' => [Products::countProducts()]
                ],
                [
                    "label" => "Sales",
                    'backgroundColor' => ['rgba(228, 115, 45, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [Sales::countSales()]
                ],
                [
                    "label" => "Finances",
                    'backgroundColor' => ['rgba(249, 195, 100, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [Finances::countFinances()]
                ],
                [
                    "label" => "Projects",
                    'backgroundColor' => ['rgba(151, 186, 241, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [Projects::countProjects()]
                ],
                [
                    "label" => "Deals",
                    'backgroundColor' => ['rgba(92, 141, 93, 1)', 'rgba(54, 162, 235, 0.3)'],
                    'data' => [Deals::countDeals()]
                ]
            ])
            ->options([]);

        return $itemsCountGraphData;
    }
}