<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    public function operationTypes()
    {
        return $this->belongsTo(OperationType::class, 'operation_type_id');
    }
}
