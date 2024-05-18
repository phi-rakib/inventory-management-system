<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'unit_type_id',
        'description',
        'quantity',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class)->select('id', 'name');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class)->select('id', 'name');
    }

    public function unitType()
    {
        return $this->belongsTo(UnitType::class)->select('id', 'name');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_product', 'product_id', 'attribute_id')
            ->withPivot('attribute_value_id');
    }

    public function attributeProducts()
    {
        return $this->hasMany(AttributeProduct::class);
    }

    public function warehouses()
    {
        return $this->belongsToMany(Warehouse::class)
            ->withPivot('quantity');
    }

    public function purchaseReturns()
    {
        return $this->belongsToMany(PurchaseReturn::class)
            ->withPivot('quantity');
    }
}
