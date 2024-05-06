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
            Stat::make('Due', function() {
                $due = Transaction::sum('total') - Payment::sum('amount');
                return $due < 0 ? 0 : $due;
            }),
        ];
    }
}
