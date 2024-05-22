<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'adjustment_date',
        'reason',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function adjustmentProducts()
    {
        return $this->hasMany(AdjustmentProduct::class);
    }
}
