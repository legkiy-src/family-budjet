<?php

namespace App\Services;

use App\Models\Currency;
use App\Repositories\AccountRepository;
use Illuminate\Database\Eloquent\Collection;

class AccountService
{
    private AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getAccounts() : Collection
    {
        $userId = auth()->user()->id;
        return $this->accountRepository->getAccounts($userId);
    }

    public function getAccountById(int $id) : array
    {
        $userId = auth()->user()->id;

        $currencies = Currency::all();
        $account = $this->accountRepository->getAccountById($id, $userId);

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
}
