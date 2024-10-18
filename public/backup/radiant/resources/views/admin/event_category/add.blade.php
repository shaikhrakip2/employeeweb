@extends('admin.layouts.main')

@section('content')
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-end">
                <div class="card-title pull-right">
                  <a href="{{ url('admin/event_categories')}}" class="btn btn-success"><i class="fa fa-list"></i> Event Category List</a>
                </div>
              </div>
              <form id="eventCategoryForm" method="post" action="{{ url('admin/event_categories') }}"  enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="name">Category Name<i class="text-danger">*</i></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name" placeholder="Enter Category name">
                          <label class="error">{{ $errors->first('name') }}</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="image">Image (Image Size must be 927px x 428px )<i class="text-danger">*</i></label>
                        <input type="file" class="form-control" name="image" id="image">
                          <p class="mb-0"><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                          <input type="hidden" name="old_image" value="<?php echo html_escape(@$data->image); ?>">
                          <label class="error">{{ $errors->first('image') }}</label>
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
     $("#eventCategoryForm").validate({
        rules: {
            name:"required",
            image:"required",
      
         },
        messages: {
            name:"Please Enter Event Category Name",
            image:"Please Select Image",
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#eventCategoryForm").valid()){
            $("#eventCategoryForm").submit();
        }
    }); 
  });  
</script>
@endsection
