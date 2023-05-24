<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Services\ArticleService;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    private ExpenseService $expenseService;
    private AccountService $accountService;
    private ArticleService $articleService;

    public function __construct(
        ExpenseService $expenseService,
        AccountService $accountService,
        ArticleService $articleService
    )
    {
        $this->expenseService = $expenseService;
        $this->accountService = $accountService;
        $this->articleService = $articleService;
    }

    public function index()
    {
        $expenses = $this->expenseService->getExpenses();

        return view(
            'expenses.expenses', [
                'expenses' => $expenses
            ]
        );
    }

    public function create(Request $request)
    {
        if (!$request->all())
        {
            $accounts = $this->accountService->getAccounts();
            $articles = $this->articleService->getArticlesByOperationTypeName('Расход');

            return view('expenses.create', [
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

        $this->expenseService->createExpense(
            $request->post('account'),
            $request->post('article'),
            $request->post('total_sum'),
            $request->post('description')
        );

        return redirect('/expenses');
    }

    public function edit(Request $request, int $id)
    {
        $accounts = $this->accountService->getAccounts();
        $articles = $this->articleService->getArticles();
        $expense = $this->expenseService->getExpenseById($id);

        if (!$request->all()) {
            return view('expenses.edit', [
                'accounts' => $accounts,
                'articles' => $articles,
                'expense' => $expense
            ]);
        }

        $request->validate([
            'account' => 'required|numeric',
            'article' => 'required|numeric',
            'total_sum' => 'required|numeric',
            'description' => 'max:255'
        ]);

        $this->expenseService->updateExpense(
            $id,
            $request->post('account'),
            $request->post('article'),
            $request->post('total_sum'),
            $request->post('description')
        );

        return redirect('/expenses');
    }

    public function delete($id)
    {
        $this->expenseService->deleteExpense($id);

        return redirect('/expenses');
    }
}
