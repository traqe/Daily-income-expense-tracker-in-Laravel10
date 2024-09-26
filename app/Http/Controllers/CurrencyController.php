<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();

        return view('frontend.currency.index', compact('currencies'));
    }

    public function update()
    {
        $previous_currency = Currency::where('selected', 1)->get()->first();
        if($previous_currency != null) {
        $previous_currency->selected = 0;
        $previous_currency->save();
        }

        $new_currency = Currency::findOrFail(request('currency'));
        $new_currency->selected = 1;

        $new_currency->save();

        return redirect()->route('currencies.index')->with('success','Currency changed successfully');
    }
}

