@extends('frontend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h3 class="mb-5 text-center">{{ $category->name }}'s Transactions</h3>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>{{ date('F d, Y', strtotime($transaction->transaction_date)) }}</td>
                                        <td>{{ $transaction->description }}</td>
                                        @if ($transaction->type == 'income')
                                            <td><a class="btn btn-success btn-sm">Income</a></td>
                                        @else
                                            <td><a class="btn btn-danger btn-sm">Expense</a></td>
                                        @endif
                                        <td>{{ $transaction->amount }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4"><p class="text-center"><i>There is no data available for now.</i></p></td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <a class="btn btn-primary btn-sm mt-5 float-center" href="{{ route('categories') }}">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
