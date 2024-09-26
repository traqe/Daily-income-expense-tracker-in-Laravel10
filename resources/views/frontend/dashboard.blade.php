@extends('frontend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Welcome {{ Auth::user()->name }}</h3>
                    </div>
                    <p class="font-weight-bold float-right">
                        Total Balance
                    <p class="text-success text-bold ml-3">
                        <strong>{{ $currency->symbol }} {{ number_format(($balance * $currency->index), 2) }} </strong>
                    </p>
                    </p>
                </div>
            </div>
        </div>
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12 grid-margin transparent">
                <div class="row">
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-dark-blue">
                            <div class="card-body">
                                <p class="mb-4">Total Income</p>
                                <p class="fs-30 text-bold ml-3">
                                    <strong>{{ $currency->symbol }} {{ number_format(($income * $currency->index), 2) }} </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 stretch-card transparent">
                        <div class="card card-tale">
                            <div class="card-body">
                                <p class="mb-4">Total Expenses</p>
                                <p class="fs-30 text-bold ml-3">
                                    <strong>{{ $currency->symbol }} {{ number_format(($expenses * $currency->index), 2) }} </strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @if ($income > 0)
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card position-relative">
                        <div class="card-body">
                            <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2"
                                data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="row">
                                            <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                                                <div class="ml-xl-6 mt-3">
                                                    <p class="card-title">Income vs Expense</p>
                                                    <h1 class="fs-30 text-success">{{ $currency->symbol }} {{ number_format(($income - $expenses) * $currency->index) }}</h1>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-xl-9">
                                                <div class="row">
                                                    <div class="col-md-12 border-right">
                                                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                                                            <table class="table table-borderless report-table">
                                                                <tr>
                                                                    <td class="text-muted">Income</td>
                                                                    <td class="w-100 px-0">
                                                                        <div class="progress progress-md mx-4">
                                                                            <div class="progress-bar bg-success"
                                                                                role="progressbar"
                                                                                style="width: {{ ($income / ($income + $expenses)) * 100 }}%"
                                                                                aria-valuenow="{{ ($income / ($income + $expenses)) * 100 }}"
                                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <h5 class="font-weight-bold mb-0">
                                                                            {{ number_format(($income * $currency->index), 2) }}</h5>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="text-muted">Expenses</td>
                                                                    <td class="w-100 px-0">
                                                                        <div class="progress progress-md mx-4">
                                                                            <div class="progress-bar bg-danger"
                                                                                role="progressbar"
                                                                                style="width: {{ ($expenses / ($income + $expenses)) * 100 }}%"
                                                                                aria-valuenow="{{ ($expenses / ($income + $expenses)) * 100 }}"
                                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <h5 class="font-weight-bold mb-0">
                                                                            {{ number_format(($expenses * $currency->index), 2) }}</h5>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <canvas id="incomeCategoryChart" width="300" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <canvas id="expenseCategoryChart" width="300" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (!empty($dailyExpenses))
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title mb-0">Daily Expenses (Last 30 Days)</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-borderless mt-5">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Total Expenses</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyExpenses as $dailyExpense)
                                            <tr>
                                                <td>{{ $dailyExpense->date }}</td>
                                                <td>{{ $currency->symbol }} {{ number_format(($dailyExpense->total * $currency->index), 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12 stretch-card grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">Latest 10 Transactions</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless mt-5">
                                <thead>
                                    <tr>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $transaction)
                                        <tr>
                                            <td>
                                                @if ($transaction->type == 'income')
                                                    <p class="text-success text-bold ml-3">
                                                        <strong>{{ $currency->symbol }} {{ number_format(($transaction->amount * $currency->index), 2) }} </strong>
                                                    </p>
                                                @elseif($transaction->type == 'expense')
                                                    <p class="text-danger text-bold ml-3">
                                                        <strong>{{ $currency->symbol }} {{ number_format(($transaction->amount * $currency->index), 2) }} </strong>
                                                    </p>
                                                @else
                                                    <p class="text-primary text-bold ml-3">
                                                        <strong>{{ $currency->symbol }} {{ number_format(($transaction->amount * $currency->index), 2) }} </strong>
                                                    </p>
                                                @endif
                                            </td>

                                            @if ($transaction->type == 'income')
                                                <td><a class="btn btn-success btn-sm">Income</a></td>
                                            @elseif ($transaction->type == 'expense')
                                                <td><a class="btn btn-danger btn-sm">Expense</a></td>
                                            @endif

                                            <td>{{ $transaction->category->name }}</td>
                                            <td>{{ $transaction->transaction_date->format('F j, Y') }}</td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <p class="text-center"><i>There is no transaction history available right
                                                        now.</i>
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (!empty($categoryData))
            <script>
                const incomeCategoryData = @json($categoryData['incomeCategories']);
                const expenseCategoryData = @json($categoryData['expenseCategories']);
                const incomeCategoryNames = incomeCategoryData.map(item => item.category_name);
                const incomeCategoryAmounts = incomeCategoryData.map(item => item.total);
                const expenseCategoryNames = expenseCategoryData.map(item => item.category_name);
                const expenseCategoryAmounts = expenseCategoryData.map(item => item.total);

                const incomeCategoryCtx = document.getElementById('incomeCategoryChart').getContext('2d');
                const incomeCategoryChart = new Chart(incomeCategoryCtx, {
                    type: 'pie',
                    data: {
                        labels: incomeCategoryNames,
                        datasets: [{
                            data: incomeCategoryAmounts,
                            backgroundColor: [
                                '#FF5733',
                                '#33FF57',
                                '#3380FF',
                                '#FF33E9',
                                '#33FFEC',
                                '#FF335E',
                                '#3377FF',
                                '#FF33A6',
                                '#33FF3A',
                                '#FFC133',
                                '#337DFF',
                                '#FF3315',
                                '#33FFC1',
                                '#336BFF',
                                '#FF339C'
                            ]
                        }],
                    },
                    options: {
                        responsive: false,
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                    },
                });

                const expenseCategoryCtx = document.getElementById('expenseCategoryChart').getContext('2d');
                const expenseCategoryChart = new Chart(expenseCategoryCtx, {
                    type: 'pie',
                    data: {
                        labels: expenseCategoryNames,
                        datasets: [{
                            data: expenseCategoryAmounts,
                            backgroundColor: [
                                '#FF5733',
                                '#33FF57',
                                '#3380FF',
                                '#FF33E9',
                                '#33FFEC',
                                '#FF335E',
                                '#3377FF',
                                '#FF33A6',
                                '#33FF3A',
                                '#FFC133',
                                '#337DFF',
                                '#FF3315',
                                '#33FFC1',
                                '#336BFF',
                                '#FF339C'
                            ]
                        }],
                    },
                    options: {
                        responsive: false,
                        legend: {
                            display: true,
                            position: 'bottom',
                        },
                    },
                });
            </script>
        @endif
    </div>
@endsection
