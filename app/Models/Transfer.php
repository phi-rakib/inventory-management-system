<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_date',
        'from_warehouse_id',
        'to_warehouse_id',
    ];

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function productTransfer()
    {
        return $this->hasMany(ProductTransfer::class);
    }
}
