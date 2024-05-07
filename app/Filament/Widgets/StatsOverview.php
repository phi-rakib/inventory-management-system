<?php

namespace App\Filament\Widgets;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\UnitType;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Categories', Category::count()),
            Stat::make('Brands', Brand::count()),
            Stat::make('Unit Types', UnitType::count()),
            Stat::make('Product', Product::count()),
            Stat::make('Supplier', Supplier::count()),
            Stat::make('Purchased', Transaction::sum('total')),
            Stat::make('Paid', Payment::sum('amount')),
            Stat::make('Due', function () {
                $transactions = Transaction::groupBy('supplier_id')
                    ->selectRaw('sum(total) as sum, supplier_id')
                    ->pluck('sum', 'supplier_id');
                
                $payments = Payment::groupBy('supplier_id')
                    ->selectRaw('sum(amount) as sum, supplier_id')
                    ->pluck('sum', 'supplier_id');
                
                $totalDue = 0;
                foreach ($transactions as $supplier_id => $sum) {
                    if(isset($payments[$supplier_id]))
                    {
                        $due = $sum - $payments[$supplier_id];
                        if($due > 0)
                        {
                            $totalDue += $due;
                        }
                    } 
                    else
                    {
                        $totalDue +=  $sum;
                    }
                }
                return $totalDue;
            }),
            Stat::make('Paid in Advance', function () {
                $transactions = Transaction::groupBy('supplier_id')
                    ->selectRaw('sum(total) as sum, supplier_id')
                    ->pluck('sum', 'supplier_id');
                
                $payments = Payment::groupBy('supplier_id')
                    ->selectRaw('sum(amount) as sum, supplier_id')
                    ->pluck('sum', 'supplier_id');
                
                $totalAdvance = 0;
                foreach ($transactions as $supplier_id => $sum) {
                    if(isset($payments[$supplier_id]))
                    {
                        $advance = $payments[$supplier_id] - $sum;
                        if($advance > 0)
                        {
                            $totalAdvance += $advance;
                        }
                    }
                }
                return $totalAdvance;
            }),
        ];
    }
}
