<?php return array (
  'barryvdh/laravel-dompdf' => 
  array (
    'aliases' => 
    array (
      'PDF' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
      'Pdf' => 'Barryvdh\\DomPDF\\Facade\\Pdf',
    ),
    'providers' => 
    array (
      0 => 'Barryvdh\\DomPDF\\ServiceProvider',
    ),
  ),
  'cknow/laravel-money' => 
  array (
    'providers' => 
    array (
      0 => 'Cknow\\Money\\MoneyServiceProvider',
    ),
  ),
  'icehouse-ventures/laravel-chartjs' => 
  array (
    'providers' => 
    array (
      0 => 'IcehouseVentures\\LaravelChartjs\\Providers\\ChartjsServiceProvider',
    ),
    'aliases' => 
    array (
      'Chartjs' => 'IcehouseVentures\\LaravelChartjs\\Facades\\Chartjs',
    ),
  ),
  'laravel/tinker' => 
  array (
    'providers' => 
    array (
      0 => 'Laravel\\Tinker\\TinkerServiceProvider',
    ),
  ),
  'nesbot/carbon' => 
  array (
    'providers' => 
    array (
      0 => 'Carbon\\Laravel\\ServiceProvider',
    ),
  ),
  'nunomaduro/collision' => 
  array (
    'providers' => 
    array (
      0 => 'NunoMaduro\\Collision\\Adapters\\Laravel\\CollisionServiceProvider',
    ),
  ),
  'nunomaduro/termwind' => 
  array (
    'providers' => 
    array (
      0 => 'Termwind\\Laravel\\TermwindServiceProvider',
    ),
  ),
);