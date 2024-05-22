<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DepositCategory;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AccountSeeder::class,
            DepositCategorySeeder::class,
            PaymentMethodSeeder::class,
            DepositSeeder::class,
            ExpenseCategorySeeder::class,
            ExpenseSeeder::class,
        ]);
    }
}
