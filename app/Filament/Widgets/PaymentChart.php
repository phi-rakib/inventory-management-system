<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;

class PaymentChart extends ChartWidget
{
    protected static ?string $heading = 'Payment Chart By Date';

    protected function getData(): array
    {
        $payments = Payment::groupBy('payment_date')
            ->selectRaw('sum(amount) as sum, payment_date')
            ->pluck('sum', 'payment_date')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Payments',
                    'data' => array_values($payments),
                ],
            ],
            'labels' => array_keys($payments),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
