@extends('frontend.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Add Category</h4>
                        <form action="{{ route('categories.store') }}" class="forms-sample" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="amount">Name</label>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Name">
                                @error('name')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection