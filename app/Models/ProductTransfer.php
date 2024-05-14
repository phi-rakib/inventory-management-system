<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransfer extends Model
{
    use HasFactory;

    protected $table = 'product_transfer';

    protected $fillable = [
        'transfer_id',
        'product_id',
        'quantity',
    ];

    public function transfer()
    {
        return $this->belongsTo(Transfer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
