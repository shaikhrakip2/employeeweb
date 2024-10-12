
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
                            type="name" class="form-control" name="name" id="name" placeholder="Enter Your Name"
                         
                            >
                        
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                                
                            @enderror

                    </div>
                    <div class="form-group"> <label>E-mail</label> <input type="email"
                            class="form-control" name="email" id="email" placeholder="Enter Your Email" 
                          
                            > 
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                                
                            @enderror

                        </div>

                    <div class="form-group"> <label>Mobile No</label> <input type="mobile"
                            class="form-control" name="mobile" id="mobile" placeholder="Enter Your Mobile No" 
                            
                            > 
                        
                            @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    <div class="form-group"> <label>Image</label> <input type="file"
                            name="image" accept="image/*" id="image"  required
                            
                            > 

                            @error('image')
                            <span class="text-danger">{{ $message }}</span>
                                
                            @enderror
                        </div>

                    <div class="form-group"> <label>City Name</label> <input type="city"
                            class="form-control" name="city" id="city" placeholder="Enter Your City" 
                           
                            > 

                            @error('city')
                            <span class="text-danger">{{ $message }}</span>
                                
                            @enderror
                        </div>

                    <div class="form-group"> <label>State Name</label> <input type="state"
                            class="form-control" name="state" id="state" placeholder="Enter Your State" 
                            
                            > 
                            @error('state')
                            <span class="text-danger">{{ $message }}</span>
                                
                            @enderror
                        
                        </div>

                    <div class="checkbox"> <label> <input type="checkbox"> Check me out
                        </label> </div> <button type="submit"
                        class="btn btn-sm btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

@endsection