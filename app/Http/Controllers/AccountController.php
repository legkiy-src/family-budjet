<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Services\AccountService;

class AccountController extends Controller
{
    private AccountService $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $accounts = $this->accountService->getAccounts();

        return view('accounts.accounts', [
            'accounts' => $accounts,
        ]);
    }

    public function edit(Request $request, int $id)
    {
        $account = $this->accountService->getAccountById($id);

        if (!$request->all()) {
            return view('accounts.edit', $account);
        }

        $this->accountService->updateAccount(
            $id,
            $request->post('name'),
            $request->post('balance'),
            $request->post('currency'),
            $request->post('description')
        );

        return redirect('/accounts');
    }

    public function delete($id)
    {
        $account = Account::where('user_id', auth()->user()->id)
            ->where('id', $id)->first();

        $account->delete();

        return redirect('/accounts');
    }

    public function create(Request $request)
    {
        $currencies = Currency::all();

        if (!$request->all()) {
            return view('accounts.create', [
                'currencies' => $currencies,
            ]);
        }

        $request->validate([
            'name' => 'required|max:255',
            'balance' => 'required|numeric',
            'currency' => 'required|numeric',
            'description' => 'max:255'
        ]);

        $this->accountService->createAccount(
            $request->post('name'),
            $request->post('balance'),
            $request->post('currency'),
            $request->post('description')
        );

        return redirect('/accounts');
    }
}
