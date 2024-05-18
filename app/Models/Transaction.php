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
    ];

    protected $with = ['payments'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function productTransaction()
    {
        return $this->hasMany(ProductTransaction::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
