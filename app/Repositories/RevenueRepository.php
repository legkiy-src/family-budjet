<?php

namespace App\Repositories;

use App\Models\Revenue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RevenueRepository
{
    public function getRevenues(int $userId) : Collection
    {
        return Revenue::with(['account', 'article'])
            ->where('user_id', '=', $userId)
            ->get();
    }

    public function createRevenue(
        int $userId,
        int $operationId,
        int $accountId,
        int $articleId,
        int $totalSum,
        ?string $description
    ) : int
    {
        $revenue = new Revenue();

        $revenue->user_id = $userId;
        $revenue->operation_id = $operationId;
        $revenue->account_id = $accountId;
        $revenue->article_id = $articleId;
        $revenue->total_sum = $totalSum;
        $revenue->description = $description;

        $revenue->save();

        return $revenue->id;
    }

    public function getRevenueById(int $userId, int $id) : ?Model
    {
        return Revenue::query()
            ->where('user_id', $userId)
            ->where('id', $id)
            ->first();
    }

    public function updateRevenue(
        int $id,
        int $userId,
        int $accountId,
        int $articleId,
        int $totalSum,
        ?string $description
    ) : bool
    {
        $revenue = Revenue::query()
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->first();

        $revenue->account_id = $accountId;
        $revenue->article_id = $articleId;
        $revenue->total_sum = $totalSum;
        $revenue->description = $description;

        return $revenue->save();
    }

    public function deleteRevenue(int $userId, int $id): mixed
    {
        return Revenue::query()
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->delete();
    }

    public function deleteRevenueByAccountId(int $userId, int $accountId): mixed
    {
        return Revenue::query()
            ->where('user_id', '=', $userId)
            ->where('account_id', '=', $accountId)
            ->delete();
    }

    public function deleteRevenueByArticleId(int $userId, int $articleId): mixed
    {
        return Revenue::query()
            ->where('user_id', '=', $userId)
            ->where('article_id', '=', $articleId)
            ->delete();
    }

    public function getSumGroupByAccountId(int $userId, int $articleId): Collection
    {
        return Revenue::query()
            ->select(
                'user_id',
                'article_id',
                'account_id',
                DB::raw('sum(total_sum) as sum')
            )
            ->groupBy('user_id', 'article_id', 'account_id', 'total_sum')
            ->having('user_id', '=', $userId)
            ->having('article_id', '=', $articleId)
            ->get();
    }
}
