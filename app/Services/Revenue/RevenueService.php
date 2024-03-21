<?php

namespace App\Services\Revenue;

use App\Repositories\AccountRepository;
use App\Repositories\RevenueRepository;
use App\Services\Account\AccountService;
use App\Services\OperationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RevenueService
{
    private RevenueRepository $revenuesRepository;
    private OperationService $operationService;
    private AccountService $accountService;
    private AccountRepository $accountRepository;
    private int $userId;

    public function __construct(
        RevenueRepository $revenuesRepository,
        AccountRepository $accountRepository,
        OperationService $operationService,
        AccountService $accountService
    )
    {
        $this->revenuesRepository = $revenuesRepository;
        $this->accountRepository = $accountRepository;
        $this->operationService = $operationService;
        $this->accountService = $accountService;
    }

    private function getUserId(): int
    {
        if (empty($this->userId)) {
            $this->userId = auth()->user()->id;
        }

        return $this->userId;
    }

    public function getRevenues(): Collection
    {
        $userId = $this->getUserId();

        return $this->revenuesRepository->getRevenues($userId);
    }

    public function createRevenue(int $accountId, int $articleId, int $totalSum, ?string $description = ''): bool
    {
        $userId = $this->getUserId();

        return DB::transaction(function () use ($userId, $accountId, $articleId, $totalSum, $description) {

            $operationId = $this->operationService->createOperation(
                $accountId,
                1,
                $totalSum,
                'revenues',
                null
            );

            $changedTotalSum = $totalSum * 100;

            $revenueId = $this->revenuesRepository->createRevenue(
                $userId,
                $operationId,
                $accountId,
                $articleId,
                $changedTotalSum,
                $description
            );

            $this->accountService->balanceIncrement($accountId, $changedTotalSum);

            return $this->operationService->updateSourceTableId($operationId, $revenueId);
        });
    }

    public function getRevenueById(int $id): ?Model
    {
        $userId = $this->getUserId();

        return $this->revenuesRepository->getRevenueById($userId, $id);
    }

    public function updateRevenue(int $id, int $accountId, int $articleId, int $totalSum, ?string $description = ''): bool
    {
        $userId = $this->getUserId();
        $revenue = $this->revenuesRepository->getRevenueById($userId, $id);
        $account = $this->accountRepository->getAccountById($userId, $accountId);

        return DB::transaction(function () use (
            $userId,
            $id,
            $accountId,
            $articleId,
            $totalSum,
            $description,
            $revenue,
            $account
        ) {
            $changedTotalSum = $totalSum * 100;

            $this->revenuesRepository->updateRevenue(
                $id,
                $userId,
                $accountId,
                $articleId,
                $changedTotalSum,
                $description
            );

            if ($account->balance === 0) {
                return $this->accountService->balanceIncrement($accountId, $changedTotalSum);
            }

            $revenueDiv = (int)bcdiv($revenue->total_sum, 100);

            if ($revenueDiv < $totalSum) {

                $balanceChange = ($totalSum - $revenueDiv) * 100;

                return $this->accountService->balanceIncrement($accountId, $balanceChange);

            } elseif ($revenueDiv > $totalSum) {

                $balanceChange = ($revenueDiv - $totalSum) * 100;

                return $this->accountService->balanceDecrement($accountId, $balanceChange);
            }

            return true;
        });
    }

    public function deleteRevenue(int $id): mixed
    {
        $userId = $this->getUserId();

        $revenue = $this->revenuesRepository->getRevenueById($userId, $id);

        return DB::transaction(function () use ($userId, $id, $revenue) {

            $this->accountService->balanceDecrement($revenue->account_id, $revenue->total_sum);

            return $this->revenuesRepository->deleteRevenue($userId, $id);
        });
    }
}
