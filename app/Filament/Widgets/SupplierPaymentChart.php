<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\Supplier;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SupplierPaymentChart extends ChartWidget
{
    protected static ?string $heading = 'Supplier Payment';

    protected function getData(): array
    {
        $supplierPayments = Payment::select(DB::raw('SUM(amount) as total_amount'), 'supplier_id')
            ->groupBy('supplier_id')
            ->with('supplier:id,name') 
            ->get()
            ->pluck('total_amount', 'supplier.name')
            ->toArray();
        
        $uniqueColors = generateUniqueColors(count($supplierPayments));

        return [
            'datasets' => [
                [
                    'label' => 'Supplier Payments',
                    'data' => array_values($supplierPayments),
                    'backgroundColor' => $uniqueColors,
                ],
            ],
            'labels' => array_keys($supplierPayments),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
