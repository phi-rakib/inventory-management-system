<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'account_number',
        'description',
        'balance',
    ];

    /**
     * Get all deposits related to this account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    /**
     * Get all expenses related to this account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Expense>
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
