@extends('admin.layouts.main')
@section('header_scripts')
<script src="{{ASSETS}}ckeditor/ckeditor.js"></script>
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
                <a href="{{ url('admin/home_cms') }}" class="btn btn-success"><i class="fa fa-list"></i> Home Cms Lists</a>
              </div>
            </div>
            <form id="cmsForm" method="post" action="{{ url('admin/home_cms', ['id' => $data->id]) }}" enctype="multipart/form-data">
              @method('PUT')
              @csrf
               <div class="card-body">
                  <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="name">Name<i class="text-danger">*</i></label>
                          <div class="form-control bggray">{{$data->name}}</div>
                          <input type="hidden" name="name" class="form-control " value="{{ old('name',$data->name) }}" id="name" placeholder="Enter  name"> 
                          <label class="error">{{ $errors->first('name') }}</label> 
                        </div>
                      </div>
                  </div>
              
                  <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="cms_contant">Cms Contant<i class="text-danger">*</i></label>
                          <textarea id="cms_contant" name="cms_contant" class="form-control ckeditor" rows="4" id="cms_contant">{{ old('cms_contant',$data->cms_contant1) }} </textarea>  
                            <label class="error">{{ $errors->first('cms_contant') }}</label> 
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col">
                     
                    </div>
                </div>
                 
                  {{-- <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" name="image" id="image">
                         <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                         <input type="hidden" name="old_image" value="<?php echo html_escape(@$data->image); ?>">
                          @if($data->image)
                             <p><img src="{{asset($data->image)}}" class="image logosmallimg"></p>
                          @endif
                          <label class="error">{{ $errors->first('image') }}</label> 
                      </div>
                    </div>
                  </div> --}}
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
    $("#cmsForm").validate({
        rules: {
          
            name:"required",
            cms_contant:"required"
         },
        messages: {
    
            name:"Please Enter  Name",
            cms_contant:"Please Enter CMS"
         
            image:{
                  required:"Please Select Photo",
                  extension:"Please upload file in these format only (jpg, jpeg, png, gif)",
                   },
         
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#cmsForm").valid()){
            $("#cmsForm").submit();
        }
    }); 
  });  
</script>
@endsection
