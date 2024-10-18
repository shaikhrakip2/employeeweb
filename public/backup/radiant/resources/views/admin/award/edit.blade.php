@extends('admin.layouts.main')

@section('content') 
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-end">
              <div class="card-title pull-right">
                <a href="{{ url('admin/awards') }}" class="btn btn-success"><i class="fa fa-list"></i>  Award Lists</a>
              </div>
            </div>
            <form id="awardForm" method="post" action="{{ url('admin/awards', ['id' => $data->id]) }}"  enctype="multipart/form-data">
              @method('PUT')
              @csrf
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="title">Award Title<i class="text-danger">*</i></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $data->title) }}" id="title" placeholder="Enter Award Title">
                          <label class="error">{{ $errors->first('title') }}</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="date">Award Date<i class="text-danger">*</i></label>
                        <input type="date" name="date" class="form-control" value="{{ old('date', $data->date) }}" id="date" placeholder="Enter Award Date">
                          <label class="error">{{ $errors->first('date') }}</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="short_description">Short Description<i class="text-danger">*</i></label>
                        <textarea type="text" name="short_description" class="form-control" id="short_description" placeholder="Enter Short Description">{{ old('short_description', $data->short_description) }}</textarea>
                          <label class="error">{{ $errors->first('short_description') }}</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="image">Award Image<i class="text-danger">*</i></label>
                        <input type="file" class="form-control" name="image" id="image" accept="image/*">
                         <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                         <input type="hidden" name="old_image" value="<?php echo html_escape(@$data->image); ?>">
                         @If($data->image)
                             <p><img src="{{asset($data->image)}}" class="image logosmallimg"></p>
                         @endif
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
      $("#awardForm").validate({
        rules: {
            title: {
                required: true,
                maxlength: 250
            },
            date: {
                required: true,
                date: true
            },
            short_description: {
                required: true,
                maxlength: 250
            },
            image: {
                required: false,
                extension: "jpg|png|gif|jpeg"
            }
        },
        messages: {
            title: {
                required: "Please Enter Award Title",
                maxlength: "Maximum 250 characters allowed"
            },
            date: {
                required: "Please Enter Award Date",
                date: "Please Enter Valid Date"
            },
            short_description: {
                required: "Please Enter Short Description",
                maxlength: "Maximum 250 characters allowed"
            },
            image: {
                extension: "Please upload file in these formats only (jpg, jpeg, png, gif)"
            }
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#awardForm").valid()){
            $("#awardForm").submit();
        }
    }); 
  });   
</script>
@endsection
