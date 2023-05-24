<?php

namespace App\Repositories;

use App\Models\Operation;

class OperationRepository
{
    public function createOperation(
        int $userId,
        int $accountId,
        int $operationTypeId,
        int $sum,
        ?string $sourceTableName,
        ?int $sourceTableId,
        ?string $description
    ): int
    {
        $operation = new Operation();

        $operation->user_id = $userId;
        $operation->account_id = $accountId;
        $operation->operation_type_id = $operationTypeId;
        $operation->sum = $sum;
        $operation->source_table_name = $sourceTableName;
        $operation->source_table_id = $sourceTableId;
        $operation->description = $description;

        $operation->save();

        return $operation->id;
    }

    public function updateSourceTableId(int $userId, int $id, int $sourceTableId) : bool
    {
        return Operation::query()
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->update(['source_table_id' => $sourceTableId]);
    }
}
