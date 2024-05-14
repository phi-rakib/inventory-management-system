<?php

namespace App\Filament\Resources\ProductAdjustmentResource\Pages;

use App\Filament\Resources\ProductAdjustmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductAdjustment extends EditRecord
{
    protected static string $resource = ProductAdjustmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
