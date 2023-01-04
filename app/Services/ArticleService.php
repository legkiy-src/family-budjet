<?php

namespace App\Services;

use App\Repositories\ArticleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class ArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getArticles() : Collection
    {
        $userId = auth()->user()->id;

        return $this->articleRepository->getArticles($userId);
    }

    public function createArticle(int $type, string $name, ?string $description) : bool
    {
        $userId = auth()->user()->id;

        return $this->articleRepository->createArticle($userId, $type, $name, $description);
    }

    public function getArticleById(int $id) : ?Model
    {
        $userId = auth()->user()->id;

        return $this->articleRepository->getArticleById($userId, $id);
    }

    public function updateArticle(int $id, int $type, string $name, ?string $description) : bool
    {
        $userId = auth()->user()->id;

        return $this->articleRepository->updateArticle($userId, $id, $type, $name, $description);
    }

    public function deleteArticle(int $id) : mixed
    {
        $userId = auth()->user()->id;
        return $this->articleRepository->deleteArticle($userId, $id);
    }
}
