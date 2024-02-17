@extends('master')
@section('body')
   <div class="container-fluid bg-secondary-subtle">
    <div class="row vh-100 d-flex justify-content-center align-content-center">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <form action="{{ route('register_post') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <h2 class="text-center">Register Form</h2>
                        @if(session()->has('success'))
                            <div class="alert alert-success">{{ session()->get('success') }}</div>
                        @endif
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="name" name="name" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" required class="form-control">
                        </div>
                        <a href="{{ route('login') }}">Go to login ?</a>
                        <button type="submit" class="btn btn-primary float-end">Register</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
   </div>
@endsection