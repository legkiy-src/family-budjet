<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Account\AccountService;
use App\Services\Article\ArticleService;
use App\Services\Expense\Exceptions\NotEnoughMoneyException;
use App\Services\Expense\ExpenseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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

    public function create()
    {
        $accounts = $this->accountService->getAccounts();
        $articles = $this->articleService->getArticlesByOperationTypeName('Расход');

        return view('expenses.create', [
            'accounts' => $accounts,
            'articles' => $articles,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $this->expenseService->createExpense(
                $request->post('account'),
                $request->post('article'),
                $request->post('total_sum'),
                $request->post('description')
            );
        } catch (NotEnoughMoneyException $exception) {
            return Redirect::back()->withInput($request->all())->withErrors([
                $exception->getMessage(),
            ]);
        }

        return redirect('/expenses');
    }

    public function edit(int $id)
    {
        $accounts = $this->accountService->getAccounts();
        $articles = $this->articleService->getArticlesByOperationTypeName('Расход');
        $expense = $this->expenseService->getExpenseById($id);

        return view('expenses.edit', [
            'accounts' => $accounts,
            'articles' => $articles,
            'expense' => $expense
        ]);
    }

    public function update(Request $request)
    {
        $this->expenseService->updateExpense(
            $request->post('id'),
            $request->post('account'),
            $request->post('article'),
            $request->post('total_sum'),
            $request->post('description')
        );

        return redirect('/expenses');
    }

    public function destroy($id)
    {
        $this->expenseService->deleteExpense($id);

        return redirect('/expenses');
    }
}
