<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Warehouse;
use Attribute;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AccountSeeder::class,
            DepositCategorySeeder::class,
            PaymentMethodSeeder::class,
            DepositSeeder::class,
            ExpenseCategorySeeder::class,
            ExpenseSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            UnitTypeSeeder::class,
            ProductSeeder::class,
            WarehouseSeeder::class,
        ]);
    }
}
