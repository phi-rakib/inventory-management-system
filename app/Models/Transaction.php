<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'transact_at',
        'total',
        'delivery_cost',
        'discount',
    ];

    protected $with = ['payments'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function productTransactions()
    {
        return $this->hasMany(ProductTransaction::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
