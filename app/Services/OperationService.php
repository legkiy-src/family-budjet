<?php


namespace App\Services;


use App\Repositories\OperationRepository;

class OperationService
{
    private OperationRepository $operationRepository;

    public function __construct(OperationRepository $operationRepository)
    {
        $this->operationRepository = $operationRepository;
    }

    public function createOperation(
        int $accountId,
        int $operationType,
        int $sum,
        ?string $sourceTableName,
        ?int $sourceTableId,
        ?string $description = ''
    ) : int
    {
        $userId = auth()->user()->id;

        return $this->operationRepository->createOperation(
            $userId,
            $accountId,
            $operationType,
            $sum * 100,
            $sourceTableName,
            $sourceTableId,
            $description
        );
    }

    public function updateSourceTableId(int $id, int $sourceTableId) : bool
    {
        $userId = auth()->user()->id;
        return $this->operationRepository->updateSourceTableId($userId, $id, $sourceTableId);
    }
}
