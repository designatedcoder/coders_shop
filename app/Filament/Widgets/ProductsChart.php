<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Product;
use Filament\Widgets\BarChartWidget;

class ProductsChart extends BarChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array {
        $products = Product::select('created_at', 'quantity')->get()->groupBy(function($products) {
            return Carbon::parse($products->created_at)->format('F');
        });
        $quantities = [];
        foreach ($products as $product => $value) {
            array_push($quantities, $value->pluck('quantity')->sum());
        }
        return [
            'datasets' => [
                [
                    'label' => 'Products in stock',
                    'data' => $quantities,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(201, 203, 207, 0.2)'
                      ],
                    'borderColor' => [
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                    ],
                    'borderWidth' => 1
                ],
            ],
            'labels' => $products->keys(),
        ];
    }
}
