<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Services\ArticleService;
use App\Services\Revenue\RevenueService;
use Illuminate\Http\Request;

class RevenuesController extends Controller
{
    private RevenueService $revenuesService;
    private AccountService $accountService;
    private ArticleService $articleService;

    public function __construct(
        RevenueService $revenuesService,
        AccountService $accountService,
        ArticleService $articleService
    )
    {
        $this->revenuesService = $revenuesService;
        $this->accountService = $accountService;
        $this->articleService = $articleService;
    }

    public function index()
    {
        $revenues = $this->revenuesService->getRevenues();

        return view(
            'revenues.revenues', [
                'revenues' => $revenues
            ]
        );
    }

    public function create(Request $request)
    {
        if (!$request->all())
        {
            $accounts = $this->accountService->getAccounts();
            $articles = $this->articleService->getArticlesByOperationTypeName('Доход');

            return view('revenues.create', [
                'accounts' => $accounts,
                'articles' => $articles,
            ]);
        }

        $request->validate([
            'account' => 'required|numeric',
            'article' => 'required|numeric',
            'total_sum' => 'required|numeric',
            'description' => 'max:255'
        ]);

        $this->revenuesService->createRevenue(
            $request->post('account'),
            $request->post('article'),
            $request->post('total_sum'),
            $request->post('description')
        );

        return redirect('/revenues');
    }

    public function edit(Request $request, int $id)
    {
        $accounts = $this->accountService->getAccounts();
        $articles = $this->articleService->getArticles();
        $revenue = $this->revenuesService->getRevenueById($id);

        if (!$request->all()) {
            return view('revenues.edit', [
                'accounts' => $accounts,
                'articles' => $articles,
                'revenue' => $revenue
            ]);
        }

        $request->validate([
            'account' => 'required|numeric',
            'article' => 'required|numeric',
            'total_sum' => 'required|numeric',
            'description' => 'max:255'
        ]);

        $this->revenuesService->updateRevenue(
            $id,
            $request->post('account'),
            $request->post('article'),
            $request->post('total_sum'),
            $request->post('description')
        );

        return redirect('/revenues');
    }

    public function delete($id)
    {
        $this->revenuesService->deleteRevenue($id);

        return redirect('/revenues');
    }
}
