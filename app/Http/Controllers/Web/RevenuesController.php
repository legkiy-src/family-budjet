<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Account\AccountService;
use App\Services\Article\ArticleService;
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

    public function create()
    {
        $accounts = $this->accountService->getAccounts();
        $articles = $this->articleService->getArticlesByOperationTypeName('Доход');

        return view('revenues.create', [
            'accounts' => $accounts,
            'articles' => $articles,
        ]);
    }

    public function store(Request $request)
    {
        $this->revenuesService->createRevenue(
            $request->post('account'),
            $request->post('article'),
            $request->post('total_sum'),
            $request->post('description')
        );

        return redirect('/revenues');
    }

    public function edit($id)
    {
        $accounts = $this->accountService->getAccounts();
        $articles = $this->articleService->getArticlesByOperationTypeName('Доход');
        $revenue = $this->revenuesService->getRevenueById($id);

        return view('revenues.edit', [
            'accounts' => $accounts,
            'articles' => $articles,
            'revenue' => $revenue
        ]);
    }

    public function update(Request $request)
    {
        $this->revenuesService->updateRevenue(
            $request->post('id'),
            $request->post('account'),
            $request->post('article'),
            $request->post('total_sum'),
            $request->post('description')
        );

        return redirect('/revenues');
    }

    public function destroy($id)
    {
        $this->revenuesService->deleteRevenue($id);

        return redirect('/revenues');
    }
}
