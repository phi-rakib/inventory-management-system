<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValueProductTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_transaction_id',
        'attribute_id',
        'attribute_value_id',
    ];

    public function transaction()
    {
        return $this->belongsTo(ProductTransaction::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }
}
