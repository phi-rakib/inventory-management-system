<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }
}
