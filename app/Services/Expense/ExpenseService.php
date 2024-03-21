<?php


namespace App\Services\Expense;


use App\Repositories\ExpenseRepository;
use App\Services\Account\AccountService;
use App\Services\Article\ArticleService;
use App\Services\Expense\Exceptions\NotEnoughMoneyException;
use App\Services\OperationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ExpenseService
{
    private ExpenseRepository $expenseRepository;
    private OperationService $operationService;
    private AccountService $accountService;
    private ArticleService $articleService;
    private int $userId;

    public function __construct(
        ExpenseRepository $expenseRepository,
        OperationService $operationService,
        AccountService $accountService,
        ArticleService $articleService
    ) {
        $this->expenseRepository = $expenseRepository;
        $this->operationService = $operationService;
        $this->accountService = $accountService;
        $this->articleService = $articleService;
    }

    private function getUserId(): int
    {
        if (empty($this->userId)) {
            $this->userId = auth()->user()->id;
        }

        return $this->userId;
    }

    public function getExpenses(): Collection
    {
        $userId = $this->getUserId();

        return $this->expenseRepository->getExpenses($userId);
    }

    public function createExpense(int $accountId, int $articleId, int $totalSum, ?string $description = ''): bool
    {
        $userId = $this->getUserId();

        return DB::transaction(
            function () use ($userId, $accountId, $articleId, $totalSum, $description) {
                $article = $this->articleService->getArticleById($articleId);

                $operationId = $this->operationService->createOperation(
                    $accountId,
                    $article->operationType->id,
                    $totalSum,
                    'expenses',
                    null
                );

                $changedTotalSum = $totalSum * 100;

                $revenueId = $this->expenseRepository->createExpense(
                    $userId,
                    $operationId,
                    $accountId,
                    $articleId,
                    $changedTotalSum,
                    $description
                );

                try {
                    $this->accountService->balanceDecrement($accountId, $changedTotalSum);
                } catch (NotEnoughMoneyException) {
                    throw new NotEnoughMoneyException();
                }

                return $this->operationService->updateSourceTableId($operationId, $revenueId);
            }
        );
    }

    public function getExpenseById(int $id): ?Model
    {
        $userId = $this->getUserId();

        return $this->expenseRepository->getExpenseById($userId, $id);
    }

    public function updateExpense(
        int $id,
        int $accountId,
        int $articleId,
        int $totalSum,
        ?string $description = ''
    ): bool {
        $userId = $this->getUserId();

        return DB::transaction(
            function () use ($userId, $id, $accountId, $articleId, $totalSum, $description) {
                $this->expenseRepository->updateExpense(
                    $id,
                    $userId,
                    $accountId,
                    $articleId,
                    $totalSum * 100,
                    $description
                );

                return $this->accountService->updateBalance($accountId, $totalSum);
            }
        );
    }

    public function deleteExpense(int $id): mixed
    {
        $userId = $this->getUserId();

        $revenue = $this->expenseRepository->getExpenseById($userId, $id);

        return DB::transaction(
            function () use ($userId, $id, $revenue) {
                $this->accountService->balanceIncrement($revenue->account_id, $revenue->total_sum);

                return $this->expenseRepository->deleteExpense($userId, $id);
            }
        );
    }
}
