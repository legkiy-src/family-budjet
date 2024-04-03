<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $connection = 'mysql';
    protected $table = 'accounts';
    public $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'name',
        'balance',
        'currency_id',
        'description',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'name' => 'string',
        'balance' => 'integer',
        'currency_id' => 'integer',
        'description' => 'string',
        'created_at' => 'string',
        'updated_at' => 'string'
    ];

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
