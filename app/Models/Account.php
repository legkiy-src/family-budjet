<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
