<?php

namespace App\Services\Article;

use App\Repositories\ArticleRepository;
use App\Repositories\OperationTypeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class ArticleService
{
    private ArticleRepository $articleRepository;
    private OperationTypeRepository $operationTypeRepository;
    private int $userId;

    public function __construct(
        ArticleRepository $articleRepository,
        OperationTypeRepository $operationTypeRepository
    )
    {
        $this->articleRepository = $articleRepository;
        $this->operationTypeRepository = $operationTypeRepository;
    }

    private function getUserId(): int
    {
        if (empty($this->userId)) {
            $this->userId = auth()->user()->id;
        }

        return $this->userId;
    }

    public function getArticles() : Collection
    {
        $userId = auth()->user()->id;

        return $this->articleRepository->getArticles($userId);
    }

    public function getArticlesByOperationTypeName(string $name) : Collection
    {
        $operationTypeId = $this->operationTypeRepository->getIdByName($name);
        return $this->articleRepository->getArticlesByOperationTypeId($operationTypeId);
    }

    public function createArticle(int $operationType, string $name, ?string $description) : bool
    {
        $userId = auth()->user()->id;

        return $this->articleRepository->createArticle($userId, $operationType, $name, $description);
    }

    public function getArticleById(int $id) : ?Model
    {
        $userId = auth()->user()->id;

        return $this->articleRepository->getArticleById($userId, $id);
    }

    public function updateArticle(int $id, int $operationTypeId, string $name, ?string $description) : bool
    {
        $userId = auth()->user()->id;

        return $this->articleRepository->updateArticle($userId, $id, $operationTypeId, $name, $description);
    }

    public function deleteArticle(int $id) : mixed
    {
        $userId = auth()->user()->id;
        return $this->articleRepository->deleteArticle($userId, $id);
    }
}
