@extends('master')
@section('body')
    <h2 class="text-primary text-center mt-5">Welcome Page</h2>
    <div class="conainter">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header text-end">
                        <button class="btn btn-sm btn-danger" type="button" onclick="handleLogout()">Logout</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-primary text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Name</label>
            <input id="ename" type="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input id="eemail" type="email" class="form-control" required>
          </div>
          <input type="hidden" id="eid">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" onclick="handleUpdate()" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection



@section('js')
    <script>
        checkAuth();
        getUser();

        function handleLogout(){
            if(confirm('Are you sure ?')){
                const URL = http + '/logout';
                $.ajax({
                    url: URL,
                    headers: {
                        'Authorization':`Bearer ${localStorage.getItem('token')}`,
                        'Accept':'application/json',
                        'key' : '123'
                    },
                    method: 'POST',
                    dataType: 'json',
                    success: function(data){
                        if(data.status == 'error'){
                            alert(data.sms);
                        } else {
                            alert(data.sms);
                            localStorage.clear();;
                            window.location.href = "{{ route('login') }}"
                        }
                    }
                });
            }
        }

        function getUser(){
            $.ajax({
                url: http + '/list/user',
                headers: {
                    'Authorization':`Bearer ${localStorage.getItem('token')}`,
                    'Accept':'application/json',
                    'key' : '123'
                },
                method: 'GET',
                dataType: 'json',
                success: function(data){
                    if(data.status == 'error'){
                        alert(data.sms);
                    } else {
                        const users = data.data;

                        let str  = '';
                        users.forEach((user,index) => {
                            str += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${user.name}</td>
                                    <td>${user.email}</td>
                                    <td>
                                        <button class="btn btn-sm btn-success" onclick=handleEdit(event,${user.id})>Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick=handleDelete(event,${user.id})>Delete</button>
                                    </td>
                                </tr>
                            `
                        });

                        $('#tbody').html(str);
                    }
                }
            });
        }

        function handleEdit(event, user_id){
            const URL = http + '/edit/user?user_id=' + user_id;
            $.ajax({
                url: URL,
                headers: {
                    'Authorization':`Bearer ${localStorage.getItem('token')}`,
                    'Accept':'application/json',
                    'key' : '123'
                },
                method: 'GET',
                dataType: 'json',
                success: function(res){
                    const user = res.data
                    $('#eemail').val(user.email);
                    $('#ename').val(user.name);
                    $('#eid').val(user.id);
                    $('#editModal').modal('show')
                }
            });
        }

        function handleUpdate(){
            const URL = http + '/update/user';
            $.ajax({
                url: URL,
                headers: {
                    'Authorization':`Bearer ${localStorage.getItem('token')}`,
                    'Accept':'application/json',
                    'key' : '123'
                },
                method: 'POST',
                dataType: 'json',
                data : {
                    user_id : $('#eid').val(),
                    name : $('#ename').val(),
                    email : $('#eemail').val()
                },
                success: function(data){
                    if(data.status == 'error'){
                        alert(data.sms);
                    } else {
                        $('#editModal').modal('hide');
                        getUser();
                    }
                }
            });
        }

        function handleDelete(event, user_id){
            if(confirm('Are you sure want to delete it ?')){
                const URL = http + '/delete/user';
                $.ajax({
                    url: URL,
                    headers: {
                        'Authorization':`Bearer ${localStorage.getItem('token')}`,
                        'Accept':'application/json',
                        'key' : '123'
                    },
                    method: 'POST',
                    dataType: 'json',
                    data : {
                        user_id : user_id,
                    },
                    success: function(data){
                        if(data.status == 'error'){
                            alert(data.sms);
                        } else {
                            getUser();
                        }
                    }
                });
            }
        }
    </script>
@endsection