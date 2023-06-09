<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ArticleRepository
{
    public function getArticles(int $userId): Collection
    {
        return Article::query()
            ->where('user_id', '=', $userId)
            ->get();
    }

    public function createArticle(int $userId, int $operationType, string $name, ?string $description) : bool
    {
        return Article::query()
            ->insert([
                'user_id' => $userId,
                'operation_type_id' => $operationType,
                'name' => $name,
                'description' => $description
            ]);
    }

    public function getArticleById(int $userId, int $id) : ?Model
    {
        return Article::with('operationType')
            ->where('user_id', $userId)
            ->where('id', $id)
            ->first();
    }

    public function updateArticle(int $userId, int $id, int $operationTypeId, string $name, ?string $description) : bool
    {
        return Article::query()
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->update([
                'operation_type_id' => $operationTypeId,
                'name' => $name,
                'description' => $description
            ]);
    }

    public function deleteArticle(int $userId, int $id): mixed
    {
        return Article::query()
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->delete();
    }

    public function getArticlesByOperationTypeId(int $operationTypeId) : Collection
    {
        return Article::query()
            ->where('operation_type_id', '=', $operationTypeId)
            ->get();
    }
}
