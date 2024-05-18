<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'deposit_date',
        'amount',
        'payment_method_id',
        'deposit_category_id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }


    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id', 'id')
            ->select('id', 'name');
    }

    public function depositCategory()
    {
        return $this->belongsTo(DepositCategory::class, 'deposit_category_id', 'id')
            ->select('id', 'name');
    }
}
