<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'amount',
        'payment_date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
