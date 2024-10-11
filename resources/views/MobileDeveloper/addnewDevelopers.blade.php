@extends('layouts.main')
@section('main-container')

<div class="row">
    <div class="col-sm-12">
        <section class="panel panel-default">
            <header class="panel-heading font-bold text-center ">Add New Developer</header>
            <div class="panel-body">
                <form action="{{ route('data-store') }}" method="POST">
                    @csrf
                    <div class="rakip">
                        <div class="form-group"> <label>Name</label> <input type="name" class="form-control" name="name" placeholder="Enter Your Name">
                        </div>
                        <div class="form-group"> <label>E-mail</label> <input type="email" class="form-control" name="email" placeholder="Enter Your Email"> </div>

                        <div class="form-group"> <label>phone No</label> <input type="phone" class="form-control" name="phone" placeholder="Enter Your phone No"> </div>

                        <div class="form-group"> <label>Address</label> <input type="address" class="form-control" name="address" placeholder="Enter Your address"> </div>

                        <div class="form-group"> <label>Designation</label> <input type="designation" class="form-control" name="designation" placeholder="Enter Your designation"> </div>

                        <div class="form-group"> <label>Company</label> <input type="company" class="form-control" name="company" placeholder="Enter Your company"> </div>
                        <div class="form-group"> <label>Working_experience</label> <input type="working_experience" class="form-control" name="working_experience" placeholder="Enter Your working_experience"> </div>
                       
                        <div class="form-group"> <label>Select Your State</label> 
                        {{-- <input type="working_experience" class="form-control" name="working_experience" placeholder="Enter Your working_experience">  --}}
                        
                        <select>
                                <option>None</option>

                                @foreach($citys as $key => $state)      
                                <option value="{{  $state['code'] }}">{{ $state['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                          

                     
                        {{-- <div class="form-group"> 
                                <label></label>
                            <select>
                                <option>None</option>
                                @foreach($citys as $key => $state)
                                <option value="{{  $state['code'] }}">{{ $state['name'] }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="checkbox"> <label> <input type="checkbox"> Check me out
                            </label> </div> <button type="submit" class="btn btn-sm btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>



    @endsection
