<?php

namespace App\Services\Currency;

use App\Repositories\CurrencyRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CurrencyService
{
    private CurrencyRepository $currencyRepository;
    private int $userId;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    private function getUserId(): int
    {
        if (empty($this->userId))
        {
            $this->userId = auth()->user()->id;
        }

        return $this->userId;
    }

    public function getCurrencies() : Collection
    {
        $userId = $this->getUserId();

        return $this->currencyRepository->getCurrenciesByUserId($userId);
    }

    public function getCurrencyById(int $id) : ?Model
    {
        $userId = $this->getUserId();

        return $this->currencyRepository->getCurrencyById($userId, $id);
    }

    public function createCurrency(string $name, string $symbol)
    {
        $userId = $this->getUserId();

        $this->currencyRepository->createCurrency($userId, $name, $symbol);
    }

    public function updateCurrency(int $id, string $name, string $symbol)
    {
        $userId = $this->getUserId();

        return $this->currencyRepository->updateCurrency($userId, $id, $name, $symbol);
    }

    public function deleteCurrency(int $id) : mixed
    {
        $userId = $this->getUserId();
        return $this->currencyRepository->deleteCurrency($userId, $id);
    }
}
