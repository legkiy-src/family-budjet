<?php

namespace App\Services;

use App\Repositories\CurrencyRepository;
use Illuminate\Database\Eloquent\Collection;

class CurrencyService
{
    private CurrencyRepository $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    public function getCurrencies() : Collection
    {
        $userId = auth()->user()->id;

        return $this->currencyRepository->getCurrenciesByUserId($userId);
    }
}
