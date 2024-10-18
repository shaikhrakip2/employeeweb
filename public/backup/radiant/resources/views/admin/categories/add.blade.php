@extends('admin.layouts.main')
 

@section('content')
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-end">
                <div class="card-title pull-right">
                  <a href="{{ url('admin/categories')}}" class="btn btn-success"><i class="fa fa-list"></i> Category Lists</a>
                </div>
              </div>
              <form id="categoriesForm" method="post" action="{{ url('admin/categories') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="row">
                      <div class="col">
                          <div class="form-group">
                            <label for="parent_id">Parent Category<i class="text-danger">*</i></label>
                             <select name="parent_id" id="parent_id"class="form-control">
                                <option value="">Select Parent Category</option>
                                <option value="0">Parent</option> 
                                @foreach ($parcat as $key => $pcat) 
                                @if(old('parent_id')== $pcat['id'])
                                <option value="{{ $pcat['id'] }}" selected>{{ $pcat['name'] }}</option>
                                @else
                                <option value="{{ $pcat['id'] }}">{{ $pcat['name'] }}</option>
                                @endif
                               @endforeach
                              </select>
                            <div class="row"><label id="parent_id-error" class="error" for="parent_id"></label></div> 
                            <label class="error">{{ $errors->first('parent_id') }}</label> 
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label for="name">Name<i class="text-danger">*</i></label>
                          <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name" placeholder="Enter  name"> 
                          <label class="error">{{ $errors->first('name') }}</label> 
                        </div>
                      </div>
                  </div>
                 
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="sort_order">Sort Order<i class="text-danger">*</i></label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order') }}" id="sort_order" placeholder="Enter Sort Order">
                        <label class="error">{{ $errors->first('sort_order') }}</label>
                      </div>
                    </div>
                  
                    <div class="col">
                                        <div class="form-group">
                                            <label for="is_featured">Is Top Category(For Home Page)<i class="text-danger">*</i></label>
                   
                                            <select name="is_featured" id="is_featured" class="form-control">
                                            <option value="">Select Is Top Or Not</option>
                                            <option value="1">Yes</option>

                                            <option value="0">No</option>
                                                </select>
                                                <label class="error">{{ $errors->first('is_featured') }}</label>


                                        
                                        </div>
                                    </div>
                    
                  </div>
                   
                  <div class="row">
                     
                      <div class="col">
                      <div class="form-group">
                        <label for="image">Image ( Image Size must be 314px x 215px )</label>
                        <input type="file" class="form-control" name="image" id="image">
                         <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
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
    
    $('#parent_id').select2(); 
    // jquery validation    
    $("#categoriesForm").validate({
        rules: {
            parent_id:"required",
            name:"required",
            meta_title:"required",
            meta_keyword:"required",
            meta_description:{
                required: true,
                minlength: 5,  
            },
            sort_order:"required", 
            is_featured: "required",
            image: {
                        required: true,
                        extension: "jpg|png|gif|jpeg",
                    },

         },
        messages: {
            parent_id:"Please Select Parent Category",
            name:"Please Enter Name",
            meta_title:"Please Enter Meta Title",
            meta_keyword:"Please Enter Meta Keyword",
            meta_description:"Please Enter Meta Description",
            is_featured: "Please Select Is Top Category",
            sort_order:"Please Enter Category Order",  
            image:{
                  required:"Please Select Photo",
                  extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                   },
         
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#categoriesForm").valid()){
            $("#categoriesForm").submit();
        }
    }); 
  });  
</script>
@endsection