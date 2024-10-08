@extends('layouts.main')
@section('main-container')

<div class="row">
    <div class="col-sm-12">
        <section class="panel panel-default">
            <header class="panel-heading font-bold text-center  ">Update Employee Information</header>
            <div class="panel-body">
                <form action="{{ route('updateemployee', $user->id) }}" method="POST">
                    @csrf
                    <div class="rakip">
                        <div class="form-group"> <label>Name</label> <input type="name" class="form-control" name="name" placeholder="Enter name"
                            value="{{ $user->name }}">
                        </div>
                        <div class="form-group"> <label>E-mail</label> <input type="email" class="form-control" name="email" placeholder="email"
                            value="{{ $user->email }}"> </div>

                        <div class="form-group"> <label>Mobile No</label> <input type="mobile" class="form-control" name="mobile" placeholder="mobile"
                            value="{{ $user->mobile }}"> </div>

                        <div class="form-group"> <label>City</label> <input type="city" class="form-control" name="city" placeholder="city"
                            value="{{ $user->city }}"> </div>

                        <div class="form-group"> <label>State</label> <input type="state" class="form-control" name="state" placeholder="state" 
                            value="{{ $user->state }}"> </div>

                        <div class="checkbox"> <label> <input type="checkbox"> Check me out
                            </label> </div> <button type="submit" class="btn btn-sm btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    @endsection
