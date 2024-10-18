@extends('admin.layouts.main')
@section('content')
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-end">
                <div class="card-title pull-right">
                  <a href="{{ url('admin/newsletter-notifications')}}" class="btn btn-success"><i class="fa fa-list"></i> Notification Lists</a>
                </div>
              </div>
              <form id="notificationForm" method="post" action="{{ url('admin/newsletter-notifications') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label for="subject">Subject<i class="text-danger">*</i></label>
                          <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" id="subject" placeholder="Enter Subject"> 
                          <label class="error">{{ $errors->first('subject') }}</label> 
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="message">Message<i class="text-danger">*</i></label>
                        <textarea id="message" name="message" class="form-control" placeholder="Enter Sort Description">{{ old('message') }} </textarea>  
                          <label class="error">{{ $errors->first('message') }}</label> 
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
    $(document).on('change', '#type', function() {
        $type = $(this).val();
        if($type == 2){
          $("#designation").val("Volunteer");
          $("#designation").prop("readonly", true);
        }else{
          $("#designation").val("");
          $("#designation").prop("readonly", false);
        }
    });
        
    // jquery validation    
    $("#notificationForm").validate({
        rules: {
            subject: "required",
            message:{
                required: true,
                minlength: 5,  
            },
         },
        messages: {
            subject:"Please Enter  Name",
            message:"Please Enter  Sort Description",
        }
    });
    $("body").on("click", ".btn-submit", function(e){
        if ($("#notificationForm").valid()){
            $("#notificationForm").submit();
        }
    }); 
  });  
</script>
@endsection