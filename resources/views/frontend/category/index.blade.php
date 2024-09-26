@extends('frontend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title mb-0">All Categories ({{ $categoryCount }})</p>
                        <a href="{{ route('categories.create') }}" class="btn btn-success float-right">Add Category</a>
                        <div class="table-responsive">
                            <table class="table table-striped table-borderless mt-5">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Name</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                    class="btn btn-primary btn-sm">Edit</a>
                                                {{-- <a href="{{ route('categories.delete', $category->id) }}"
                                                    onclick="return confirm('Are you sure you want to delete?')"
                                                    class="btn btn-danger btn-sm">Delete</a> --}}
                                                <a href="{{ route('categories.transaction.view', $category->id) }}"
                                                    class="btn btn-warning btn-sm">View Transactions</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                <p class="text-center"><i>There is no category available right now.</i></p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            {{ $categories->links('custom-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
