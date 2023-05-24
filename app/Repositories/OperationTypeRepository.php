<?php

namespace App\Repositories;

use App\Models\OperationType;
use Illuminate\Database\Eloquent\Collection;

class OperationTypeRepository
{
    public function getAllOperationsTypes() : Collection
    {
        return OperationType::all();
    }

    public function getIdByName(string $name) : int
    {
        return OperationType::query()
            ->where('name', '=', $name)
            ->value('id');
    }
}
