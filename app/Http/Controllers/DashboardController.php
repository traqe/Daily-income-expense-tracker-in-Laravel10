<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currencies = Currency::all();

        if($currencies == NULL){
            $currency = new Currency();
            $currency->name = "USD";
            $currency->index = 1;
            $currency->symbol = "$";
            $currency->selected = 1;
            $currency->save();
        }

        $user = Auth::user();

        $transactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $total_transaction=Transaction::where('user_id',$user->id)->get();

        $income = $total_transaction->where('type', 'income')->sum('amount');
        $expenses = $total_transaction->where('type', 'expense')->sum('amount');
        $investments = $total_transaction->where('type', 'investment')->sum('amount');

        $balance = $income - $expenses;

        $categoryData = $this->categoryData();

        $currency = Currency::where('selected', 1)->get()->first();

        return view('frontend.dashboard', [
            'income' => $income,
            'expenses' => $expenses,
            'investments'=>$investments,
            'transactions' => $transactions,
            'balance' => $balance,
            'categoryData' => $categoryData,
            'currency' => $currency
        ]);
    }

    public function categoryData()
    {
        $user = Auth::user();

        $incomeCategories = Transaction::selectRaw('categories.name as category_name, SUM(transactions.amount) as total')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'income')
            ->groupBy('categories.name')
            ->get();

        $expenseCategories = Transaction::selectRaw('categories.name as category_name, SUM(transactions.amount) as total')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->groupBy('categories.name')
            ->get();

        return [
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories,
        ];
    }

}
