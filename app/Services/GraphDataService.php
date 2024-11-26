<?php

namespace App\Services;

use App\Queries\DealQueries;
use App\Queries\FinanceQueries;
use App\Queries\ProductQueries;
use App\Queries\SaleQueries;

class GraphDataService
{
    private int $width = 400;
    private int $height = 200;

    public function taskGraphData()
    {
        $cash = new CalculateCashService();

        $labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $datasets = [
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
        ];

        return app()->chartjs
            ->name('taskGraphData')
            ->type('line')
            ->size(['width' => $this->width, 'height' => $this->height])
            ->labels($labels)
            ->datasets($datasets)
            ->options([]);
    }


    /**
     * @return mixed
     */
    public function itemsCountGraphData(): mixed
    {
        $data = [
            'Products' => ProductQueries::countAll(),
            'Sales' => SaleQueries::countAll(),
            'Finances' => FinanceQueries::countAll(),
            'Deal' => DealQueries::countAll(),
        ];

        $colors = [
            'Products' => ['rgba(227, 67, 51, 1)', 'rgba(54, 162, 235, 0.2)'],
            'Sales' => ['rgba(228, 115, 45, 1)', 'rgba(54, 162, 235, 0.3)'],
            'Finances' => ['rgba(249, 195, 100, 1)', 'rgba(54, 162, 235, 0.3)'],
            'Deal' => ['rgba(92, 141, 93, 1)', 'rgba(54, 162, 235, 0.3)'],
        ];

        $datasets = [];

        foreach ($data as $label => $count) {
            $datasets[] = [
                'label' => $label,
                'backgroundColor' => $colors[$label],
                'data' => [$count],
            ];
        }

        return app()->chartjs
            ->name('cashTurnoverGraphData')
            ->type('bar')
            ->size(['width' => $this->width, 'height' => $this->height])
            ->datasets($datasets)
            ->options([]);
    }
}
