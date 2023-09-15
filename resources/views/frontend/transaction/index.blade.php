@extends('frontend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">All Transactions ({{ $transactionCount }})</p>
                        <a href="{{ route('transactions.create') }}" class="btn btn-success float-right">Add Transactions</a>
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless mt-5">
                                <thead>
                                    <tr>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $transaction)
                                        <tr>
                                            <td>
                                                @if ($transaction->type == 'income')
                                                    <p class="text-success text-bold ml-3">
                                                        <strong>Nrs. {{ number_format($transaction->amount, 2) }} </strong>
                                                    </p>
                                                @elseif($transaction->type == 'expense')
                                                    <p class="text-danger text-bold ml-3">
                                                        <strong>Nrs. {{ number_format($transaction->amount, 2) }} </strong>
                                                    </p>
                                                @else
                                                    <p class="text-primary text-bold ml-3">
                                                        <strong>Nrs. {{ number_format($transaction->amount, 2) }} </strong>
                                                    </p>
                                                @endif
                                            </td>
                                            @if ($transaction->type == 'income')
                                                <td><a class="btn btn-success btn-sm">Income</a></td>
                                            @elseif($transaction->type == 'expense')
                                                <td><a class="btn btn-danger btn-sm">Expense</a></td>
                    
                                            @endif

                                            <td>{{ $transaction->category->name }}</td>
                                            <td>{{ $transaction->transaction_date->format('F j, Y') }}</td>
                                            <td>
                                                <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                <a href="{{ route('transactions.delete', $transaction->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete?')"
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <p class="text-center"><i>There is no transaction available right now.</i>
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            {{ $transactions->links('custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
