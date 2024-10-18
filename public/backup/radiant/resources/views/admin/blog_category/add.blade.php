@extends('admin.layouts.main')

@section('content')
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-end">
                <div class="card-title pull-right">
                  <a href="{{ url('admin/blog_categories')}}" class="btn btn-success"><i class="fa fa-list"></i> Blog Category List</a>
                </div>
              </div>
              <form id="bannerForm" method="post" action="{{ url('admin/blog_categories') }}"  enctype="multipart/form-data">
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
     $("#bannerForm").validate({
        rules: {
            name:"required",
            sort_order:"required",
      
         },
        messages: {
            name:"Please Enter Blog Category Name",

            sort_order:"Please Enter Banner Sort Order",
           
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#bannerForm").valid()){
            $("#bannerForm").submit();
        }
    }); 
  });  
</script>
@endsection
