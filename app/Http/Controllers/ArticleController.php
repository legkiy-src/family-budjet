<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\OperationTypeService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    private ArticleService $articleService;
    private OperationTypeService $operationTypeService;

    public function __construct(
        ArticleService $articleService,
        OperationTypeService $operationTypeService
    )
    {
        $this->articleService = $articleService;
        $this->operationTypeService = $operationTypeService;
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
            $operationTypes = $this->operationTypeService->getAllOperationsTypes();

            return view('articles.create', [
                'operationTypes' => $operationTypes
            ]);
        }

        $request->validate([
            'operationType' => 'required|numeric',
            'name' => 'required|max:255',
            'description' => 'max:255'
        ]);

        $this->articleService->createArticle(
            $request->post('operationType'),
            $request->post('name'),
            $request->post('description')
        );

        return redirect('/articles');
    }

    public function edit(Request $request, int $id)
    {
        $article = $this->articleService->getArticleById($id);
        $operationTypes = $this->operationTypeService->getAllOperationsTypes();

        if (!$request->all()) {
            return view('articles.edit', [
                'article' => $article,
                'operationTypes' => $operationTypes
            ]);
        }

        $this->articleService->updateArticle(
            $id,
            $request->post('operationType'),
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
