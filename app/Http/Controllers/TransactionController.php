<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $transactions = Transaction::with('category')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $transaction = Transaction::where('user_id', $user->id)->get();
        $transactionCount = count($transaction);
        return view('frontend.transaction.index', compact('transactions', 'transactionCount'));
    }

    public function create()
    {
        $user = Auth::user();

        $categories = Category::where('user_id', $user->id)->orderBy('name', 'asc')->get();
        return view('frontend.transaction.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "type" => "required",
            "category_id" => "required",
            "amount" => "required",
            "description" => "nullable",
        ]);

        $user = Auth::user();

        Transaction::create([
            "type" => $data['type'],
            "category_id" => $data['category_id'],
            "amount" => $data['amount'],
            "description" => $data['description'],
            "user_id" => $user->id,
            "transaction_date" => Carbon::now(),
        ]);

        return redirect()->route('transactions');
    }

    public function edit($id)
    {
        $user = Auth::user();

        $transaction = Transaction::find($id);
        $categories = Category::where('user_id', $user->id)->orderBy('name', 'asc')->get();

        return view('frontend.transaction.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "type" => "required",
            "category_id" => "required",
            "amount" => "required",
            "description" => "nullable",
            "time_period" => "nullable",
            "interest_rate" => "nullable"
        ]);

        $user = Auth::user();

        $transaction = Transaction::where('user_id', $user->id)
            ->find($id);

        if ($transaction) {
            $transaction->update([
                "type" => $data['type'],
                "category_id" => $data['category_id'],
                "time_period" => $data['time_period'],
                "interest_rate" => $data['interest_rate'],
                "amount" => $data['amount'],
                "description" => $data['description'],
            ]);
        }

        return redirect()->route('transactions');
    }


    public function delete($id)
    {
        $user = Auth::user();

        $transaction = Transaction::where('user_id', $user->id)
            ->find($id);

        if ($transaction) {
            $transaction->delete();
        }

        return redirect()->route('transactions');
    }
}
