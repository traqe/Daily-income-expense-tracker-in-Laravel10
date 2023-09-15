@extends('frontend.layouts.app')

@section('content')
    <div class="content-wrapper">
        @if (!empty($monthlyData['income']) && !empty($monthlyData['expenses']))
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Monthly Income and Expenses</h4>
                            <div class="table-responsive mt-5">
                                <table class="table table-striped table-borderless mt-5">
                                    <thead>
                                        <tr>
                                            <th>Year</th>
                                            <th>Month</th>
                                            <th>Income</th>
                                            <th>Expenses</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($monthlyData['income'] as $key => $income)
                                            <tr>
                                                <td>{{ date('Y', mktime(0, 0, 0, $income->month, 1)) }}</td>
                                                <td>{{ date('F', mktime(0, 0, 0, $income->month, 1)) }}</td>
                                                <td>
                                                    @if (isset($monthlyData['income'][$key]))
                                                        Nrs. {{ number_format($income->total, 2) }}
                                                    @else
                                                        Nrs.0
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($monthlyData['expenses'][$key]))
                                                        Nrs. {{ number_format($monthlyData['expenses'][$key]->total, 2) }}
                                                    @else
                                                        Nrs.0
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4"><p class="text-center"><i>There is no data available for now.</i></p></td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                There is no monthly income and expense data available for the current year.
            </div>
        @endif
    </div>
@endsection
