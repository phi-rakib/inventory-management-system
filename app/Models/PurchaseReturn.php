<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'quantity',
        'reason',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function purchaseReturnProducts()
    {
        return $this->hasMany(PurchaseReturnProduct::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity');
    }
}
