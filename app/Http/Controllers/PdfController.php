<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
class PdfController extends Controller
{
    public function report()
    {

        $user = Auth::user();
        $total_transaction=Transaction::where('user_id',$user->id)->get();

        if(count($total_transaction) != 0) {

            // total of income and expenses
            $income_total = $total_transaction->where('type', 'income')->sum('amount');
            $expenses_total = $total_transaction->where('type', 'expense')->sum('amount');

            $data = ['title' => 'Balance Book Report', 'content' => [$total_transaction, $user, $income_total, $expenses_total]];
            //dd($data);
            $pdf = Pdf::loadView('frontend.pdf_report', $data);
            //dd($pdf);
            return $pdf->download('Balance Book Report.pdf');
        }
        else {
            return redirect()->route('dashboard')->with('error','Cannot generate report, you have no transactions yet');
        }
    }
}
