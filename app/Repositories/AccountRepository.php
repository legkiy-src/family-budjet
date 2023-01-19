<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AccountRepository
{
    public function getAccounts(int $userId): Collection
    {
        return Account::with(['currency'])
            ->where('user_id', $userId)
            ->get();
    }

    public function getAccountById(int $id, int $userId): ?Model
    {
        return Account::query()
            ->where('user_id', $userId)
            ->where('id', $id)
            ->first();
    }

    public function updateAccount(int $userId, int $id, ?string $name, ?int $balance,
                                  ?int $currency, ?string $description): int
    {
        return Account::query()
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->update([
                'name' => $name,
                'balance' => $balance,
                'currency_id' => $currency,
                'description' => $description
            ]);
    }

    public function deleteAccount(int $userId, int $id): mixed
    {
        return Account::query()
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->delete();
    }

    public function createAccount(int $userId, string $name, int $balance, int $currency, ?string $description): bool
    {
        return Account::query()
            ->insert([
                'user_id' => $userId,
                'name' => $name,
                'balance' => $balance,
                'currency_id' => $currency,
                'description' => $description
            ]);
    }

    public function updateBalance(int $userId, int $id, float $balance): bool
    {
        $account = Account::query()
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->first();

        $account->balance = $balance;

        return $account->save();
    }
}
