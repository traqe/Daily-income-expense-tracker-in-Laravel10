@extends('frontend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Edit Transaction</h4>
                        <form action="{{ route('transactions.update', $transaction->id) }}" class="forms-sample"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" class="form-control" id="type">
                                    <option value="">SELECT ONE</option>
                                    <option value="income" @if ($transaction->type === 'income') selected @endif>Income</option>
                                    <option value="expense" @if ($transaction->type === 'expense') selected @endif>Expense
                                    </option>
                                    
                                </select>
                                @error('type')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" class="form-control" id="category_id">
                                    <option value="">SELECT ONE</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            @if ($transaction->category_id == $cat->id) selected @endif>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount (Nrs.)</label>
                                <input type="number" name="amount" class="form-control" id="amount"
                                    placeholder="Amount" value="{{ $transaction->amount }}">
                                @error('amount')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea rows="4" name="description" class="form-control" id="description">{{ $transaction->description }}</textarea>
                                @error('description')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Update Transaction</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
