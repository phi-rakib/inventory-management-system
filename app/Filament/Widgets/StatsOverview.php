<?php

namespace App\Filament\Widgets;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Deposit;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\UnitType;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Purchased', Transaction::sum('total')),
            Stat::make('Paid', Payment::sum('amount')),
            Stat::make('Due', function () {
                $transactions = Transaction::sum('total');

                $payments = Payment::sum('amount');

                return $transactions - $payments;
            }),
            Stat::make('Deposited', Deposit::sum('amount')),
            Stat::make('Expense', Expense::sum('amount')),
            Stat::make('Categories', Category::count()),
            Stat::make('Brands', Brand::count()),
            Stat::make('Unit Types', UnitType::count()),
            Stat::make('Product', Product::count()),
            Stat::make('Supplier', Supplier::count()),
        ];
    }
}
