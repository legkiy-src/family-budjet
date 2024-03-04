<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Repositories\CurrencyRepository;
use App\Services\Expense\Exceptions\NotEnoughMoneyException;
use Illuminate\Database\Eloquent\Collection;

class AccountService
{
    private AccountRepository $accountRepository;
    private CurrencyRepository $currencyRepository;

    public function __construct(
        AccountRepository $accountRepository,
        CurrencyRepository $currencyRepository
    )
    {
        $this->accountRepository = $accountRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function getAccounts() : Collection
    {
        $userId = auth()->user()->id;
        return $this->accountRepository->getAccounts($userId);
    }

    public function getAccountById(int $id) : array
    {
        $userId = auth()->user()->id;
        $currencies = $this->currencyRepository->getCurrenciesByUserId($userId);
        $account =  $this->accountRepository->getAccountById($id, $userId);

        return [
            'account' => $account,
            'currencies' => $currencies
        ];
    }

    public function updateAccount(int $id, ?string $name, ?int $balance, ?int $currency, ?string $description) : int
    {
        $userId = auth()->user()->id;

        return $this->accountRepository->updateAccount($userId, $id, $name, $balance * 100, $currency, $description);
    }

    public function deleteAccount(int $id) : mixed
    {
        $userId = auth()->user()->id;

        return $this->accountRepository->deleteAccount($userId, $id);
    }

    public function createAccount(string $name, int $balance, int $currency, ?string $description) : bool
    {
        $userId = auth()->user()->id;

        return $this->accountRepository->createAccount($userId, $name, $balance * 100, $currency, $description);
    }

    public function updateBalance(int $id, int $balance) : bool
    {
        $userId = auth()->user()->id;

        return $this->accountRepository->updateBalance($userId, $id, $balance * 100);
    }

    public function balanceIncrement(int $id, int $sum) : bool
    {
        $userId = auth()->user()->id;
        $account = $this->accountRepository->getAccountById($id, $userId);
        $account->balance += $sum * 100;

        return $account->save();
    }

    public function balanceDecrement(int $id, int $sum) : bool
    {
        $userId = auth()->user()->id;

        $account = $this->accountRepository->getAccountById($id, $userId);
        $decrementedValue = $sum * 100;

        if ($account->balance < $decrementedValue)
        {
            $account->balance = 0;
        }
        else
        {
            $account->balance -= $sum * 100;
        }

        return $account->save();
    }
}
