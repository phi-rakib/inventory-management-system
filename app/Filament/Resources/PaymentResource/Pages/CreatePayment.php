<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    public function mount(): void
    {
        $purchaseId = request()->input('transaction_id');
        
        if ($purchaseId) {
            $this->form->fill([
                'transaction_id' => $purchaseId,
            ]);
        }
    }
}
