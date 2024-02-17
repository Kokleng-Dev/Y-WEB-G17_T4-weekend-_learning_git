@extends('master')
@section('body')
   <div class="container-fluid bg-secondary-subtle">
    <div class="row vh-100 d-flex justify-content-center align-content-center">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <form onsubmit="handleSubmit(event)">
                    <div class="card-body">
                        <h2 class="text-center">Login Form</h2>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input id="email" type="email" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="password">Password</label>
                            <input id="password" type="password" required class="form-control">
                        </div>
                        <a href="{{ route('register') }}">No Account ?</a>
                        <button type="submit" class="btn btn-primary float-end">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
   </div>
@endsection

@section('js')
    <script>
        if(localStorage.getItem('token')){
            window.location.href = "{{ route('home') }}";
        }
        function handleSubmit(event){
            event.preventDefault();
            const URL = http + '/login';
            $.ajax({
                url: URL,
                headers: {
                    // 'Authorization':'Basic xxxxxxxxxxxxx',
                    // 'X-CSRF-TOKEN':'xxxxxxxxxxxxxxxxxxxx',
                    // 'Content-Type':'application/json',
                    'key' : '123'
                },
                method: 'POST',
                dataType: 'json',
                data: {
                    'email' : $('#email').val(),
                    'password' : $('#password').val()
                },
                success: function(data){
                    if(data.status == 'error'){
                        alert(data.sms);
                    } else {
                        alert(data.sms);
                        localStorage.setItem('token', data.token);
                        window.location.href = "{{ route('home') }}"
                    }
                }
            });
        }
    </script>
@endsection