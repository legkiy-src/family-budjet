<?php

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CurrencyRepository
{
    public function getCurrenciesByUserId(int $userId) : Collection
    {
        return Currency::query()
            ->where('user_id', $userId)
            ->get();
    }

    public function getCurrencyById(int $userId, int $id) : ?Model
    {
        return Currency::query()
            ->where('user_id', $userId)
            ->where('id', $id)
            ->first();
    }

    public function createCurrency(int $userId, string $name, string $symbol) : bool
    {
        return Currency::query()
            ->insert([
                'user_id' => $userId,
                'name' => $name,
                'symbol' => $symbol
            ]);
    }

    public function updateCurrency(int $userId, int $id, string $name, string $symbol) : bool
    {
        return Currency::query()
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->update([
                'name' => $name,
                'symbol' => $symbol
            ]);
    }

    public function deleteCurrency(int $userId, int $id): mixed
    {
        return Currency::query()
            ->where('user_id', '=', $userId)
            ->where('id', '=', $id)
            ->delete();
    }
}
