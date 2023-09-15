<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailyDataController extends Controller
{
    public function index()
    {
        $dailyExpenses = $this->dailyExpenses();
        $dailyIncomes = $this->dailyIncomes();
        
        $expenseCategories = $this->expenseCategories($dailyExpenses);

        $averageDailyExpense = $this->averageDailyExpense($dailyExpenses);
        $averageDailyIncome = $this->averageDailyIncome($dailyIncomes);

        return view('frontend.daily_data.index', compact('dailyExpenses','dailyIncomes', 'expenseCategories', 'averageDailyExpense','averageDailyIncome'));
    }

    public function expenseCategories($dailyExpenses)
    {
        $user_id = Auth::user()->id;

        $expenseCategories = DB::table('transactions')
            ->select('categories.name', DB::raw('SUM(transactions.amount) as total'))
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.type', 'expense')
            ->whereIn(DB::raw('DATE(transactions.transaction_date)'), $dailyExpenses->pluck('date'))
            ->groupBy('categories.name')
            ->where('categories.user_id', $user_id)
            ->orderByDesc('total')
            ->get();

        return $expenseCategories;
    }

    public function dailyExpenses()
    {
        $user = Auth::user();

        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(30);

        $dailyExpenses = Transaction::selectRaw('DATE(transaction_date) as date, SUM(amount) as total')
            ->where('user_id', $user->id)
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->latest()
            ->get();

        return $dailyExpenses;
    }

    public function dailyIncomes()
    {
        $user = Auth::user();

        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(30);

        $dailyIncomes = Transaction::selectRaw('DATE(transaction_date) as date, SUM(amount) as total')
            ->where('user_id', $user->id)
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->latest()
            ->get();

        return $dailyIncomes;
    }

    public function averageDailyExpense($dailyExpenses)
    {
        $initialDate = '2023-08-21';
        $startDate = Carbon::today()->subDays(29);
        $endDate = Carbon::today();

        if ($startDate < $initialDate) {
            $startDate = $initialDate;
        }

        $dateRange = [];

        $date = Carbon::parse($startDate);
        for (; $date->lte($endDate); $date->addDay()) {
            $dateRange[] = $date->toDateString();
        }

        $totalExpenses = $dailyExpenses->sum('total');
        $numberOfDaysWithExpenses = $dailyExpenses->count();
        $numberOfDaysWithZeroExpenses = count(array_diff($dateRange, $dailyExpenses->pluck('date')->toArray()));

        $totalNumberOfDays = count($dateRange);

        if ($totalNumberOfDays > 0) {
            return number_format($totalExpenses / $totalNumberOfDays, 2);
        }

        return 0.00;
    }

    public function averageDailyIncome($dailyIncomes)
    {
        $initialDate = '2023-08-21';
        $startDate = Carbon::today()->subDays(29);
        $endDate = Carbon::today();

        if ($startDate < $initialDate) {
            $startDate = $initialDate;
        }

        $dateRange = [];

        $date = Carbon::parse($startDate);
        for (; $date->lte($endDate); $date->addDay()) {
            $dateRange[] = $date->toDateString();
        }

        $totalIncome = $dailyIncomes->sum('total');
        $numberOfDaysWithIncome = $dailyIncomes->count();
        $numberOfDaysWithZeroIncome = count(array_diff($dateRange, $dailyIncomes->pluck('date')->toArray()));

        $totalNumberOfDays = count($dateRange);

        if ($totalNumberOfDays > 0) {
            return number_format($totalIncome / $totalNumberOfDays, 2);
        }

        return 0.00;
    }
}
