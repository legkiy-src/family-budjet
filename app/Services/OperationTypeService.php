<?php

namespace App\Services;

use App\Repositories\OperationTypeRepository;
use Illuminate\Database\Eloquent\Collection;

class OperationTypeService
{
    private OperationTypeRepository $operationTypeRepository;

    public function __construct(OperationTypeRepository $operationTypeRepository)
    {
        $this->operationTypeRepository = $operationTypeRepository;
    }

    public function getAllOperationsTypes() : Collection
    {
        return $this->operationTypeRepository->getAllOperationsTypes();
    }
}
