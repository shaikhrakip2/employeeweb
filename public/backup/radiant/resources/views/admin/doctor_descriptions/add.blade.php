@extends('admin.layouts.main')
@section('content')
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-end">
                <div class="card-title pull-right">
                  <a href="{{ url('admin/doctor-descriptions')}}" class="btn btn-success"><i class="fa fa-list"></i> Doctor Descriptions List</a>
                </div>
              </div>
              <form id="doctorDescriptionForm" method="post" action="{{ url('admin/doctor-descriptions') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="name">Name<i class="text-danger">*</i></label>
                          <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name" placeholder="Enter  name"> 
                          @error('name')
                          <label class="error">{{ $errors->first('name') }}</label> 
                          @enderror
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="qualification">Qualification<i class="text-danger">*</i></label>
                          <input type="text" name="qualification" class="form-control" value="{{ old('qualification') }}" id="qualification" placeholder="Enter  qualification"> 
                          @error('qualification')
                          <label class="error">{{ $errors->first('qualification') }}</label> 
                          @enderror
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="description">Description<i class="text-danger">*</i></label>
                          <textarea id="description" name="description" class="form-control" rows="4" placeholder="Enter Description">{{ old('description') }} </textarea>  
                            @error('description')
                            <label class="error">{{ $errors->first('description') }}</label> 
                            @enderror
                        </div>
                      </div>
                  </div>
                  <div class="row">
                     <div class="col">
                      <div class="form-group">
                        <label for="sort_order">Sort Order<i class="text-danger">*</i></label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order') }}" id="sort_order" placeholder="Enter Sort Order">
                        @error('sort_order')
                        <label class="error">{{ $errors->first('sort_order') }}</label>
                        @enderror
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                         <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                         <input type="hidden" name="old_image" value="<?php echo html_escape(@$data->image); ?>">
                         @error('image')
                         <label class="error">{{ $errors->first('image') }}</label> 
                         @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <input type="submit" name="submit" value="Submit" class="btn btn-submit btn-primary pull-right">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section> 
@endsection

@section('footer_scripts')
<script type="text/javascript">
  $(document).ready(function(){   
    

    // jquery validation    
    $("#doctorDescriptionForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 250
            },
            qualification: {
                required: true,
                maxlength: 250
            },
            description:{
                required: true,
                minlength: 5,  
            },
            sort_order:"required",
            image:{
                    required:true,
                    extension:"jpg|png|gif|jpeg",
                    },

         },
        messages: {
            name: {
                required: "Please Enter  name",
                maxlength: "The name may not be greater than 250 characters."
            },
            qualification: {
                required: "Please Enter  qualification",
                maxlength: "The qualification may not be greater than 250 characters."
            },
            description:"Please Enter  description",
            sort_order:"Please Enter  Order",
            image:{
                  required:"Please Select Photo",
                  extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                   },
         
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#doctorDescriptionForm").valid()){
            $("#doctorDescriptionForm").submit();
        }
    }); 
  });  
</script>
@endsection