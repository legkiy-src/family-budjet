<?php

namespace App\Repositories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository
{
    public function getCurrenciesByUserId(int $userId) : Collection
    {
        return Currency::query()
            ->where('user_id', $userId)
            ->get();
    }
}
