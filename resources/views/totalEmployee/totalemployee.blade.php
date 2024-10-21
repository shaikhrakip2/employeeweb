@extends('layouts.main')
@section('main-container')
    <section id="content">
        <section class="vbox">
            <section class="panel panel-default scrollable padder">

                <form action="">

                    <span class="col-sm-6" style="display: flex; padding: 20px;">
                        <a>
                            Search:<input type="search" id="" class="form-control" name="search" placeholder=""
                                value="{{ $search }}"
                                @if (isset($message)) <div class="alert alert-info " >
                                {{ $message }}
                            </div>
                            @else
                            <div class="alert alert-danger">
                                No message available.
                            </div> @endif
                                {{-- <div id="message">php echo $message; </div> --}} </a>



                            <button type="search" id="search" class="btn btn-primary btn-sm justify-center"
                                style="flex;height: 31px; margin-top: 19px;
                         padding-bottom: 27px;">search</button>
                    </span>

                </form>


                <div style="display: flex; justify-content: space-between">
                    <header class="panel panel-heading"></header>
                    <span style="margin: 10px">
                        <a href="{{ route('addnewemployee') }}" class="btn btn-s-md btn-primary"
                            style="border-radius: 10px">Add Employee</a>
                    </span>
                </div>






                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table id="tableemployee" class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" name="checkbox" id="selectAllCheckbox"></th>

                                                <th>
                                                    <select name="" id="" class="form-control">
                                                        <option value="">select</option>
                                                        <option value="">Delete</option>
                                                    </select>
                                                </th>

                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Mobile</th>
                                                <th>Image</th>
                                                <th>city</th>
                                                <th>State</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td><input type="checkbox" name="checkbox" class="userCheckbox"></td>
                                                    <td></td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->mobile }}</td>
                                                    <td><img src="{{ Storage::url($user->image) }}"
                                                            alt="user Image {{ $user->image }}"
                                                            style="max-width: 50px; height: 50px; border-radius: 10px;">
                                                    </td>
                                                    <td>{{ $user->city }}</td>
                                                    <td>{{ $user->state }}</td>
                                                    <td>
                                                        <a href="" class="btn btn-info" data-toggle="modal"
                                                            data-target="#exampleModal">
                                                            <i class="fa fa-eye"></i>
                                                        </a>

                                                        <a href="{{ route('edit-employee', $user->id) }} ">
                                                            <button class="btn btn-primary" title="edit">
                                                                <i class="fa fa-edit"></i>
                                                            </button>
                                                        </a>

                                                        <a href="{{ url('/delete') }}/{{ $user->id }}"
                                                            onclick="confirmation(event)">
                                                            <button class="btn btn-danger" title="delete" data-id="">
                                                                <i class="fa fa-trash-o"></i>
                                                            </button></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
            </section>
        </section> <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen, open"
            data-target="#nav,html"></a>
    </section>
    <aside class="bg-light lter b-l aside-md hide" id="notes">
        <div class="wrapper">Notification</div>
    </aside>
    </section>
    </section>
    </section>


  

    <script>
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            swal({
                    title: "Are You Sure To Delete This",
                    text: "You wont be able to revert this delete",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCancel) => {
                    if (willCancel) {
                        window.location.href = urlToRedirect;
                    }
                })
        }



        document.getElementById('selectAllCheckbox').onclick = function() {
            var checkboxes = document.querySelectorAll('.userCheckbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        };
    </script>


    {{-- <script>

        setTimeout(function() {
            var messageDiv = document.getElementById('message');
            messageDiv.style.opacity = 0; 
            setTimeout(function() {
                messageDiv.style.display = 'none';
            }, 1000); 
        }, 1000); 
    </script> --}}



<style>
    .close{
        position: absolute;
        left: 95%;
        top: 10%;
        transform: translate(-95%,-10%);
    }
   
</style>
    <div class="modal fade" style="position: absolute; top: 50%; left: 50%; transform:translate(-50%,-50%);"
        id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Employee Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="card">
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table id="tableemployee" class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Image</th>
                                                    <th>city</th>
                                                    <th>State</th>
                                                   

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <form action="{{ route('viewemployeedata', $user->id) }}">
                                                    <tr>
                                                        <td>{{ $user->id }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->mobile }}</td>
                                                        <td><img src="{{ Storage::url($user->image) }}"
                                                                alt="user Image {{ $user->image }}"
                                                                style="max-width: 50px; height: 50px; border-radius: 10px;">
                                                        </td>
                                                        <td>{{ $user->city }}</td>
                                                        <td>{{ $user->state }}</td>
                                                    </tr>

                                                </form>

                                            </tbody>
                                        </table>




                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endsection
