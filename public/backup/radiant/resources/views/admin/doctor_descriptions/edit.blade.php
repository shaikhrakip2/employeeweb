@extends('admin.layouts.main')
@section('header_scripts')
<script src="{{VENDOR}}ckeditor/ckeditor/ckeditor.js"></script>
@stop
@section('content') 
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-end">
              <div class="card-title pull-right">
                <a href="{{ url('admin/doctor-descriptions') }}" class="btn btn-success"><i class="fa fa-list"></i>  Doctor Descriptions List</a>
              </div>
            </div>
            <form id="doctorDescriptionsForm" method="post" action="{{ url('admin/doctor-descriptions', ['id' => $data->id]) }}" enctype="multipart/form-data">
              @method('PUT')
              @csrf
               <div class="card-body">
                  <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="name">Name<i class="text-danger">*</i></label>
                          <input type="text" name="name" class="form-control" value="{{ old('name',$data->name) }}" id="name" placeholder="Enter  name"> 
                          @error('name')
                          <label class="error">{{ $errors->first('name') }}</label> 
                          @enderror
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="qualification">Qualification<i class="text-danger">*</i></label>
                          <input type="text" name="qualification" class="form-control" value="{{ old('qualification',$data->qualification) }}" id="qualification" placeholder="Enter  qualification"> 
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
                          <textarea id="description" name="description" class="form-control" rows="4" >{{ old('description',$data->description) }} </textarea>  
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
                            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$data->sort_order) }}" id="sort_order" placeholder="Enter Sort Order">
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
                              @if($data->image)
                                 <p><img src="{{asset($data->image)}}" class="image logosmallimg"></p>
                              @endif
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
    $("#doctorDescriptionsForm").validate({
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
                    required:false,
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
                  extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                   },
         
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#doctorDescriptionsForm").valid()){
            $("#doctorDescriptionsForm").submit();
        }
    }); 
  });  
</script>
@endsection
