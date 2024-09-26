@extends('frontend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Add Transaction</h4>
                        <form action="{{ route('transactions.store') }}" class="forms-sample" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" class="form-control" id="type">
                                    <option value="">SELECT ONE</option>
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>

                                </select>
                                @error('type')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category_id" class="form-control" id="category_id">
                                    <option value="">SELECT ONE</option>
                                    @forelse ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @empty
                                        <option disabled><p class="text-center">Please add category first.</p></option>
                                    @endforelse
                                </select>
                                @error('category_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount ($)</label>
                                <input type="number" name="amount" class="form-control" id="amount" placeholder="Amount">
                                @error('amount')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea rows="4" name="description" class="form-control" id="description"></textarea>
                                @error('description')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Add Transaction</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
