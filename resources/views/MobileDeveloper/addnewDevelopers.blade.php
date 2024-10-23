@extends('layouts.main')
@section('main-container')

<div class="row">
    <div class="col-sm-12">
        <section class="panel panel-default">
            <header class="panel-heading font-bold text-center ">Add New Developer</header>
            <div class="panel-body">
                <form action="{{ route('data-store') }}" id="form" method="POST">
                    @csrf
                    <div class="rakip">

                        <div class="form-group"> <label for="title" >Name</label> <input type="name" id="title" class="form-control  @error('title') is-invalid @enderror" name="name" placeholder="Enter Your Name">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror                    
                        </div>

                        <div class="form-group"> <label>E-mail</label> <input type="email" id="email" class="form-control" name="email" placeholder="Enter Your Email"> 
                          
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                                
                            @enderror
                        </div>

                        <div class="form-group"> <label>phone No</label> <input type="phone" id="phone" class="form-control" name="phone" placeholder="Enter Your phone No"> 
                           
                            @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                                
                            @enderror
                        </div>
                        <div class="form-group"> <label>Address</label> <input type="address" id="address" class="form-control" name="address" placeholder="Enter Your address"> 
                          
                            @error('address')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group"> <label>Designation</label> <input type="designation" id="designation" class="form-control" name="designation" placeholder="Enter Your designation"> 
                        
                            @error('designation')
                            <span class="text-danger">{{ $message }}</span>
                                
                            @enderror
                        </div>

                        <div class="form-group"> <label>Company</label> <input type="company" id="company" class="form-control" name="company" placeholder="Enter Your company"> 
                             
                            @error('company')
                            <span class="text-danger">{{ $message }}</span>
                                
                            @enderror
                        </div>
                        <div class="form-group"> <label>Working_experience</label> <input id="working_experience" type="working_experience" class="form-control" name="working_experience" placeholder="Enter Your working_experience"> 
                            
                            @error('working_experience')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        
                       <div>                   
                        <label for="options">Choose Your State</label>
                        {{-- <select id="options" name="options" class="col-md-12 form-control">
                                <option>None</option>
                                @foreach($citys as $key => $state)      
                                <option value="{{  $state['code'] }}">{{ $state['name'] }}</option>
                                @endforeach
                            </select> --}}
                        </div><br>
                        <div class="checkbox"> <label> <input type="checkbox"> Check me out
                            </label> </div> <button type="submit" class="btn btn-sm btn-default">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

     <script>
        // $(document).ready(function() {
        //     $('#options').change(function() {
        //         if ($(this).val() === 'other') {
        //             $('#other-input').show();
        //         } else {
        //             $('#other-input').hide();
        //         }
        //     });
        // });



        // $(document).ready(function{
        //     $('#form').click(function{
        //         $('#options').change(function(){
        //             if($(this).val() === 'other'){
        //                 $('#other-input').show();
        //             }else{
        //                 $('#other-input').hide();
        //             }
        //         })
        //     })
            
        // })


    </script> 
    




    @endsection
