<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonthlyDataController extends Controller
{
    public function index()
    {
        $monthlyData = $this->monthlyData();

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $categoryData = $this->monthlyCategoryData($currentYear, $currentMonth);
        $currency = Currency::where('selected', 1)->get()->first();

        return view('frontend.monthly_data.index', compact('monthlyData','categoryData', 'currency'));
    }

    public function monthlyCategoryData($year, $month)
    {
        $user = Auth::user();

        $incomeCategories = Transaction::selectRaw('categories.name as category_name, SUM(transactions.amount) as total')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'income')
            ->whereYear('transactions.transaction_date', $year)
            ->whereMonth('transactions.transaction_date', $month)
            ->groupBy('categories.name')
            ->get();

        $expenseCategories = Transaction::selectRaw('categories.name as category_name, SUM(transactions.amount) as total')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.type', 'expense')
            ->whereYear('transactions.transaction_date', $year)
            ->whereMonth('transactions.transaction_date', $month)
            ->groupBy('categories.name')
            ->get();

        return [
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories,
        ];
    }

    public function monthlyData()
    {
        $user = Auth::user();

        $monthlyIncome = Transaction::selectRaw('SUM(amount) as total')
            ->selectRaw('MONTH(transaction_date) as month')
            ->where('user_id', $user->id)
            ->where('type', 'income')
            ->whereYear('transaction_date', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(transaction_date)'))
            ->orderBy(DB::raw('MONTH(transaction_date)'))
            ->get();

        $monthlyExpenses = Transaction::selectRaw('SUM(amount) as total')
            ->selectRaw('MONTH(transaction_date) as month')
            ->where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereYear('transaction_date', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(transaction_date)'))
            ->orderBy(DB::raw('MONTH(transaction_date)'))
            ->get();

        $currency = Currency::where('selected', 1)->get()->first();
        return view('frontend.monthly_data.index', [
            'monthlyData' => [
                'income' => $monthlyIncome,
                'expenses' => $monthlyExpenses,
            ],
            'currency' => $currency,
        ]);
    }
}
