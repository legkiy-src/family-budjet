<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Currency\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    private CurrencyService $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function index()
    {
        $currencies = $this->currencyService->getCurrencies();

        return view('currencies.currencies', [
            'currencies' => $currencies,
        ]);
    }

    public function create()
    {
        return view('currencies.create');
    }

    public function store(Request $request)
    {
        $this->currencyService->createCurrency(
            $request->post('name'),
            $request->post('symbol'),
        );

        return redirect('/currencies');
    }

    public function edit(int $id)
    {
        $currency = $this->currencyService->getCurrencyById($id);

        return view('currencies.edit', [
            'currency' => $currency,
        ]);
    }

    public function update(Request $request)
    {
        $this->currencyService->updateCurrency(
            $request->post('id'),
            $request->post('name'),
            $request->post('symbol')
        );

        return redirect('/currencies');
    }

    public function destroy(int $id)
    {
        $this->currencyService->deleteCurrency($id);

        return redirect('/currencies');
    }
}
