@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block margin10">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div> 
@endif

@if ($message = Session::get('error')) 
    <div class="alert alert-danger alert-block margin10">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>  
@endif

@if ($message = Session::get('warning')) 
    <div class="alert alert-warning alert-block margin10">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>  
@endif

@if ($message = Session::get('info')) 
    <div class="alert alert-info alert-block margin10">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>  
@endif

