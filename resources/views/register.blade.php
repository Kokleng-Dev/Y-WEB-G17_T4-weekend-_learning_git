@extends('master')
@section('body')
   <div class="container-fluid bg-secondary-subtle">
    <div class="row vh-100 d-flex justify-content-center align-content-center">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Register Form</h2>
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="name" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" required class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" required class="form-control">
                    </div>
                    <a href="{{ route('login') }}">Go to login ?</a>
                    <button class="btn btn-primary float-end">Register</button>
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
   </div>
@endsection