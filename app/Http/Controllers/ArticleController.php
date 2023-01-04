<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    public function index()
    {
        $articles = $this->articleService->getArticles();

        return view(
            'articles.articles', [
                'articles' => $articles
            ]
        );
    }

    public function create(Request $request)
    {
        if (!$request->all())
        {
            return view('articles.create', [

            ]);
        }

        $request->validate([
            'type' => 'required|numeric',
            'name' => 'required|max:255',
            'description' => 'max:255'
        ]);

        $this->articleService->createArticle(
            $request->post('type'),
            $request->post('name'),
            $request->post('description')
        );

        return redirect('/articles');
    }

    public function edit(Request $request, int $id)
    {
        $article = $this->articleService->getArticleById($id);

        if (!$request->all()) {
            return view('articles.edit', [
                'article' => $article
            ]);
        }

        $this->articleService->updateArticle(
            $id,
            $request->post('type'),
            $request->post('name'),
            (string)$request->post('description')
        );

        return redirect('/articles');
    }

    public function delete($id)
    {
        $this->articleService->deleteArticle($id);

        return redirect('/articles');
    }
}
