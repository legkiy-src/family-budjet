<?php

namespace App\Services;

use App\Repositories\RevenuesRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RevenueService
{
    private RevenuesRepository $revenuesRepository;
    private OperationService $operationService;
    private AccountService $accountService;

    public function __construct(
        RevenuesRepository $revenuesRepository,
        OperationService $operationService,
        AccountService $accountService
    )
    {
        $this->revenuesRepository = $revenuesRepository;
        $this->operationService = $operationService;
        $this->accountService = $accountService;
    }

    public function getRevenues(): Collection
    {
        $userId = auth()->user()->id;

        return $this->revenuesRepository->getRevenues($userId);
    }

    public function createRevenue(int $accountId, int $articleId, int $totalSum, ?string $description = '') : bool
    {
        $userId = auth()->user()->id;

        $account = $this->accountService->getAccountById($accountId);

        return DB::transaction(function () use ($userId, $accountId, $articleId, $totalSum, $description, $account) {

            $operationId = $this->operationService->createOperation(
                $accountId,
                1,
                $totalSum,
                'revenues',
                null
            );

            $revenueId = $this->revenuesRepository->createRevenue(
                $userId,
                $operationId,
                $accountId,
                $articleId,
                $totalSum * 100,
                $description
            );

            $balance = ($account['account']->balance + $totalSum) * 100;

            $this->accountService->balanceIncrement($accountId, $balance);

            return $this->operationService->updateSourceTableId($operationId, $revenueId);
        });
    }

    public function getRevenueById(int $id): ?Model
    {
        $userId = auth()->user()->id;

        return $this->revenuesRepository->getRevenueById($userId, $id);
    }

    public function updateRevenue(int $id, int $accountId, int $articleId, int $totalSum, ?string $description = ''): bool
    {
        $userId = auth()->user()->id;

        return DB::transaction(function () use ($userId, $id, $accountId, $articleId, $totalSum, $description) {

            $this->revenuesRepository->updateRevenue(
                $id,
                $userId,
                $accountId,
                $articleId,
                $totalSum * 100,
                $description
            );

            return $this->accountService->updateBalance($accountId, $totalSum);
        });
    }

    public function deleteRevenue(int $id) : mixed
    {
        $userId = auth()->user()->id;

        $revenue = $this->revenuesRepository->getRevenueById($userId, $id);

        return DB::transaction(function () use ($userId, $id, $revenue) {

            $this->accountService->balanceDecrement($revenue->account_id, $revenue->total_sum);

            return $this->revenuesRepository->deleteRevenue($userId, $id);
        });
    }
}
