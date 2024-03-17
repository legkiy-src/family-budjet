<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Article\ArticleService;
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

    public function create()
    {
        $operationTypes = $this->operationTypeService->getAllOperationsTypes();

        return view('articles.create', [
            'operationTypes' => $operationTypes
        ]);
    }

    public function store(Request $request)
    {
        $this->articleService->createArticle(
            $request->post('operationType'),
            $request->post('name'),
            $request->post('description')
        );

        return redirect('/articles');
    }

    public function edit(int $id)
    {
        $article = $this->articleService->getArticleById($id);
        $operationTypes = $this->operationTypeService->getAllOperationsTypes();

        return view('articles.edit', [
            'article' => $article,
            'operationTypes' => $operationTypes
        ]);
    }

    public function update(Request $request)
    {
        $this->articleService->updateArticle(
            $request->post('id'),
            $request->post('operationType'),
            $request->post('name'),
            (string)$request->post('description')
        );

        return redirect('/articles');
    }

    public function destroy($id)
    {
        $this->articleService->deleteArticle($id);

        return redirect('/articles');
    }
}
