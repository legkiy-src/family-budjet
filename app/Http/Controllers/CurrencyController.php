<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Services\CurrencyService;
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

    public function create(Request $request)
    {
        if (!$request->all()) {
            return view('currencies.create', [
                'currencies' => Currency::all(),
            ]);
        }

        $request->validate([
            'name' => 'required|max:20',
            'symbol' => 'required|max:20',
        ]);

        $currency = new Currency();
        $currency->user_id = auth()->user()->id;
        $currency->name = $request->post('name');
        $currency->symbol = $request->post('symbol');
        $currency->save();

        return redirect('/currencies');
    }

    public function edit(Request $request, $id)
    {
        $currency = Currency::where('user_id', auth()->user()->id)
            ->where('id', $id)->first();

        if (!$request->all()) {
            return view('currencies.edit', [
                'currency' => $currency,
            ]);
        }

        $currency->user_id = auth()->user()->id;
        $currency->name = $request->post('name');
        $currency->symbol = $request->post('symbol');
        $currency->save();

        return redirect('/currencies');
    }

    public function delete(int $id)
    {
        $currency = Currency::where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->first();

        $currency->delete();

        return redirect('/currencies');
    }
}
