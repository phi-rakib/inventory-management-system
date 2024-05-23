<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    use HasFactory;

    protected $table = 'product_transaction';

    protected $fillable = [
        'product_id',
        'transaction_id',
        'quantity',
        'unit_price',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributeValueProductTransactions()
    {
        return $this->hasMany(AttributeValueProductTransaction::class);
    }
}
