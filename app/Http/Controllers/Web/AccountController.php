<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Currency\CurrencyService;
use Illuminate\Http\Request;
use App\Services\Account\AccountService;

class AccountController extends Controller
{
    private AccountService $accountService;
    private CurrencyService $currencyService;

    public function __construct(
        AccountService $accountService,
        CurrencyService $currencyService
    )
    {
        $this->accountService = $accountService;
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $accounts = $this->accountService->getAccounts();

        return view('accounts.accounts', [
            'accounts' => $accounts,
        ]);
    }

    public function create()
    {
        $currencies = $this->currencyService->getCurrencies();

        return view('accounts.create', [
            'currencies' => $currencies,
        ]);
    }

    public function store(Request $request)
    {
        $this->accountService->createAccount(
            $request->post('name'),
            $request->post('balance'),
            $request->post('currency'),
            $request->post('description')
        );

        return redirect('/accounts');
    }

    public function edit($id)
    {
        $account = $this->accountService->getAccountById($id);

        return view('accounts.edit', $account);
    }

    public function update(Request $request)
    {
        $this->accountService->updateAccount(
            $request->post('id'),
            $request->post('name'),
            $request->post('balance'),
            $request->post('currency'),
            $request->post('description')
        );

        return redirect('/accounts');
    }

    public function destroy($id)
    {
        $this->accountService->deleteAccount($id);

        return redirect('/accounts');
    }
}
