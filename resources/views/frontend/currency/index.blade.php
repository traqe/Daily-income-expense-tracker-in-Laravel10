@extends('frontend.layouts.app')

@section('content')
    <div class="content-wrapper">

        @if(!session('success'))
        <div class="alert alert-info">
            The default currency is <strong>$ - USD (United States Dollars)</strong>
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('currencies.update') }}" method="POST">
                                @csrf
                                @method('put')
                                <div class="form-group col-8">
                                    <label for="currrency">Selected Preffered Currency</label>
                                    <select name="currency" class="form-control" id="currency">
                                        <option value="{{ $currencies[0]->id }}" selected>{{ $currencies[0]->name }} (default)</option>
                                        @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary">Change Currency</button>
                                </div>
                            </form>
                            <h4 class="card-title">Currencies</h4>
                            <div class="table-responsive mt-5">
                                <table class="table table-striped table-borderless mt-5">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Currency</th>
                                            <th>Symbol</th>
                                            <th>Convesion (to usd)</th>
                                            <th>Currently in use</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($currencies as $currency)
                                            <tr>
                                                <td>{{ $currency->id }}</td>
                                                <td>{{ $currency->name }}</td>
                                                <td><strong>{{ $currency->symbol }}</strong></td>
                                                <td>{{ $currency->symbol }}{{ $currency->index }} - $1</td>
                                                @if($currency->selected == 0)
                                                <td> no </td>
                                                @else
                                                <td> yes </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
