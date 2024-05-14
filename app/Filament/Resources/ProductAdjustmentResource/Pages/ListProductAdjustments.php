<?php

namespace App\Filament\Resources\ProductAdjustmentResource\Pages;

use App\Filament\Resources\ProductAdjustmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductAdjustments extends ListRecords
{
    protected static string $resource = ProductAdjustmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
