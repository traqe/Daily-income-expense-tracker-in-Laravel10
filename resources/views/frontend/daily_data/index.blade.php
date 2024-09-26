@extends('frontend.layouts.app')

@section('content')
    <div class="content-wrapper">
        @if (!empty($dailyExpenses) && !empty($dailyIncomes))
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="top-0 end-0 m-3">
                                <div class="bg-success text-white p-2 rounded mb-3">
                                    <strong>Average Daily Income:</strong> <span class="float-right"> {{ $currency->symbol }}
                                        {{ number_format($averageDailyIncome * $currency->index, 2) }} </span>
                                </div>
                                <div class="bg-danger text-white p-2 rounded">
                                    <strong>Average Daily Expense:</strong> <span class="float-right"> {{ $currency->symbol }}
                                        {{ number_format($averageDailyExpense * $currency->index, 2) }} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title mb-0">Income History (Last 30 Days)</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="dailyIncomeChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const dailyIncomeData = @json($dailyIncomes);
                const incomeDates = dailyIncomeData.map(item => item.date);
                const incomes = dailyIncomeData.map(item => item.total);

                const incomeBarColors = incomes.map(income => {
                    if (income >= 5000) {
                        return 'rgba(0, 255, 0, 0.6)';
                    } else if (income >= 1000 && income < 5000) {
                        return 'rgba(255, 255, 0, 0.6)';
                    } else {
                        return 'rgba(255, 0, 0, 0.6)';
                    }
                });

                const incomeCtx = document.getElementById('dailyIncomeChart').getContext('2d');
                const dailyIncomeChart = new Chart(incomeCtx, {
                    type: 'bar',
                    data: {
                        labels: incomeDates,
                        datasets: [{
                            label: ' ',
                            data: incomes,
                            backgroundColor: incomeBarColors,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <p class="card-title mb-0">Daily Expenses (Last 30 Days)</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <canvas id="dailyExpenseChart" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const dailyExpenseData = @json($dailyExpenses);
                const dates = dailyExpenseData.map(item => item.date);
                const expenses = dailyExpenseData.map(item => item.total);

                const barColors = expenses.map(expense => {
                    if (expense >= 800) {
                        return 'rgba(255, 0, 0, 0.6)';
                    } else if (expense >= 300 && expense < 800) {
                        return 'rgba(255, 255, 0, 0.6)';
                    } else {
                        return 'rgba(0, 255, 0, 0.6)';
                    }
                });
                const ctx = document.getElementById('dailyExpenseChart').getContext('2d');
                const dailyExpenseChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: ' ',
                            data: expenses,
                            backgroundColor: barColors,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Expense Categories (Last 30 Days)</h4>
                            <div class="table-responsive">
                                @if ($expenseCategories->isNotEmpty())
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Category Name</th>
                                                <th>Total Amount ({{ $currency->symbol }})</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expenseCategories as $category)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>{{ number_format(($category->total * $currency->index), 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="card-text">No expenses recorded in the past 30 days.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
