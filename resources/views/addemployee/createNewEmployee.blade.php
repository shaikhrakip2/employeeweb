
@extends('layouts.main')
@section('main-container')

<div class="row">
    <div class="col-sm-12">
        <section class="panel panel-default">
            <header class="panel-heading font-bold text-center ">New Employee</header>
            <div class="panel-body">
                <form action="{{ route('storenewemployee') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="rakip">
                    <div class="form-group"> <label>Name</label> <input
                            type="name" class="form-control" name="name" placeholder="Enter Your Name"
                         
                            >
                    </div>
                    <div class="form-group"> <label>E-mail</label> <input type="email"
                            class="form-control" name="email" placeholder="Enter Your Email" 
                          
                            > </div>

                    <div class="form-group"> <label>Mobile No</label> <input type="mobile"
                            class="form-control" name="mobile" placeholder="Enter Your Mobile No" 
                            
                            > </div>

                    <div class="form-group"> <label>Image</label> <input type="file"
                            name="image" accept="image/*"  required
                            
                            > </div>

                    <div class="form-group"> <label>City Name</label> <input type="city"
                            class="form-control" name="city" placeholder="Enter Your City" 
                           
                            > </div>

                    <div class="form-group"> <label>State Name</label> <input type="state"
                            class="form-control" name="state" placeholder="Enter Your State" 
                            
                            > </div>

                    <div class="checkbox"> <label> <input type="checkbox"> Check me out
                        </label> </div> <button type="submit"
                        class="btn btn-sm btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection