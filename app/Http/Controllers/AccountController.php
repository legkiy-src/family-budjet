<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::with(['currency'])
            ->where('user_id', auth()->user()->id)
            ->get();

        return view('accounts.accounts', [
            'accounts' => $accounts,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $currencies = Currency::all();
        $account = Account::where('user_id', auth()->user()->id)
            ->where('id', $id)->first();

        if (!$request->all()) {
            return view('accounts.edit', [
                'account' => $account,
                'currencies' => $currencies,
            ]);
        }

        $account->user_id = auth()->user()->id;
        $account->name = $request->post('name');
        $account->balance = $request->post('balance') * 100;
        $account->currency_id = $request->post('currency');
        $account->description = $request->post('description');
        $account->save();

        return redirect('/accounts');
    }

    public function delete($id)
    {
        $account = Account::where('user_id', auth()->user()->id)
            ->where('id', $id)->first();

        $account->delete();

        return redirect('/accounts');
    }

    public function create(Request $request)
    {
        //dd($request->post('id'));
        //dd(auth()->user()->name);

        $currencies = Currency::all();

        if (!$request->all()) {
            return view('accounts.create', [
                'currencies' => $currencies,
            ]);
        }

        $request->validate([
            'name' => 'required|max:255',
            'balance' => 'required|numeric',
            'currency' => 'required|numeric',
            'description' => 'max:255'
        ]);

        $account = new Account();
        $account->user_id = auth()->user()->id;
        $account->name = $request->post('name');
        $account->balance = $request->post('balance') * 100;
        $account->currency_id = $request->post('currency');
        $account->description = $request->post('description');
        $account->save();

        return redirect('/accounts');
    }
}
