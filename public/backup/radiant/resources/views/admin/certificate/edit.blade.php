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
                                <a href="{{ url('admin/certificate') }}" class="btn btn-success"><i
                                        class="fa fa-list"></i> Certificate Lists</a>
                            </div>
                        </div>
                        <form id="categoriesForm" method="post"
                            action="{{ url('admin/certificate', ['id' => $data->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Certificate Name<i class="text-danger">*</i></label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $data->name) }}" id="name"
                                                placeholder="Enter Certificate name">
                                            <label class="error">{{ $errors->first('name') }}</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Image<i class="text-danger">*</i></label>
                                            <input type="file" class="form-control" name="image" id="image"
                                                accept="image/*">
                                            <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                                            <input type="hidden" name="old_image" value="<?php echo html_escape(@$data->image); ?>">

                                            <label class="error">{{ $errors->first('image') }}</label>
                                        </div>
                                        @if ($data->image)
                                            <p><img src="{{ asset($data->image) }}" class="image logosmallimg"></p>
                                        @endif
                                    </div>

                                </div>

                                

                                <div class="card-footer">
                                    <input type="submit" name="submit" value="Submit"
                                        class="btn btn-submit btn-primary pull-right">
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
        $(document).ready(function() {
            $("#categoriesForm").validate({
                rules: {
                    name: "required",
                

                    image: {
                        required: false,
                        extension: "jpg|png|gif|jpeg",
                    },
                },
                messages: {
                    name: "Please Enter Certificate Name",
             
                    image: {
                        required: "Please Select Photo",
                        extension: "Please upload file in these format only (jpg, jpeg, png, gif)",
                    },

                }
            });
            $("body").on("click", ".btn-submit", function(e) {
                if ($("#categoriesForm").valid()) {
                    $("#categoriesForm").submit();
                }
            });
        });
    </script>
@endsection
