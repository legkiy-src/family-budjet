<?php

namespace App\Services\Article;

use App\Repositories\ArticleRepository;
use App\Repositories\ExpenseRepository;
use App\Repositories\OperationTypeRepository;
use App\Repositories\RevenueRepository;
use App\Services\Account\AccountService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ArticleService
{
    private ArticleRepository $articleRepository;
    private OperationTypeRepository $operationTypeRepository;
    private RevenueRepository $revenueRepository;
    private ExpenseRepository $expenseRepository;
    private AccountService $accountService;
    private int $userId;

    public function __construct(
        ArticleRepository $articleRepository,
        OperationTypeRepository $operationTypeRepository,
        RevenueRepository $revenueRepository,
        ExpenseRepository $expenseRepository,
        AccountService $accountService,
    ) {
        $this->articleRepository = $articleRepository;
        $this->operationTypeRepository = $operationTypeRepository;
        $this->revenueRepository = $revenueRepository;
        $this->expenseRepository = $expenseRepository;
        $this->accountService = $accountService;
    }

    private function getUserId(): int
    {
        if (empty($this->userId)) {
            $this->userId = auth()->user()->id;
        }

        return $this->userId;
    }

    public function getArticles(): Collection
    {
        $userId = $this->getUserId();

        return $this->articleRepository->getArticles($userId);
    }

    public function getArticlesByOperationTypeName(string $name): Collection
    {
        $operationTypeId = $this->operationTypeRepository->getIdByName($name);
        return $this->articleRepository->getArticlesByOperationTypeId($operationTypeId);
    }

    public function createArticle(int $operationType, string $name, ?string $description): bool
    {
        $userId = $this->getUserId();

        return $this->articleRepository->createArticle($userId, $operationType, $name, $description);
    }

    public function getArticleById(int $id): ?Model
    {
        $userId = $this->getUserId();

        return $this->articleRepository->getArticleById($userId, $id);
    }

    public function updateArticle(int $id, int $operationTypeId, string $name, ?string $description): bool
    {
        $userId = $this->getUserId();

        return $this->articleRepository->updateArticle($userId, $id, $operationTypeId, $name, $description);
    }

    public function deleteArticle(int $id): mixed
    {
        $userId = $this->getUserId();

        return DB::transaction(
            function () use (
                $userId,
                $id
            ) {
                $sumGroupRevenues = $this->revenueRepository->getSumGroupByAccountId($userId, $id);

                foreach ($sumGroupRevenues as $sumGroupRevenuesItem) {
                    $this->accountService->balanceDecrement(
                        $sumGroupRevenuesItem->account_id,
                        $sumGroupRevenuesItem->sum
                    );
                }

                $sumGroupExpenses = $this->expenseRepository->getSumGroupByAccountId($userId, $id);

                foreach ($sumGroupExpenses as $sumGroupExpensesItem) {
                    $this->accountService->balanceIncrement(
                        $sumGroupExpensesItem->account_id,
                        $sumGroupExpensesItem->sum
                    );
                }

                $this->revenueRepository->deleteRevenueByArticleId($userId, $id);
                $this->expenseRepository->deleteExpenseByArticleId($userId, $id);

                return $this->articleRepository->deleteArticle($userId, $id);
            }
        );
    }
}
