@extends('admin.layouts.main')
@section('header_scripts')
    <script src="{{ ASSETS }}ckeditor/ckeditor.js"></script>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-end">
                            <div class="card-title pull-right">
                                <a href="{{ url('admin/event') }}" class="btn btn-success"><i class="fa fa-list"></i> Event
                                    Lists</a>
                            </div>
                        </div>
                        <form id="eventForm" method="post" action="{{ url('admin/event', ['id' => $data->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Select Event Category<i class="text-danger">*</i></label>
                                            <select name="category_1" id="category_1" class="form-select">
                                                <option value="">Select Category</option>
                                                @foreach ($parcat as $l1Key => $l1Value)
                                                    <option value="{{ $l1Value['id'] }}"
                                                        {{ $data['category_id'] == $l1Value['id'] ? 'selected' : '' }}>
                                                        {{ $l1Value['name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_1')
                                                <label class="error">{{ $errors->first('category_1') }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="title">Event Title<i class="text-danger">*</i></label>
                                                <input type="text" name="title" class="form-control"
                                                    value="{{ $data->title ?? old('title') }}" id="title"
                                                    placeholder="Enter Event title">
                                                @error('title')
                                                    <label class="error">{{ $errors->first('title') }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date">Event Date<i class="text-danger">*</i></label>
                                                <input type="date" name="date" class="form-control"
                                                    value="{{ $data->date ?? old('date') }}" id="date"
                                                    placeholder="Enter Event Date">
                                                @error('date')
                                                    <label class="error">{{ $errors->first('date') }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sort_order">Event Order<i class="text-danger">*</i></label>
                                                <input type="text" name="sort_order" class="form-control"
                                                    value="{{ $data->sort_order ?? old('sort_order') }}" id="sort_order"
                                                    placeholder="Enter Event Sort Order"
                                                    onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                                                @error('sort_order')
                                                    <label class="error">{{ $errors->first('sort_order') }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image">Event Image<i class="text-danger">*</i></label>
                                                <input type="file" class="form-control" name="image" id="image">
                                                <p class="mb-0"><small class="text-success">Allowed Types: gif, jpg, png,
                                                        jpeg</small></p>
                                                <input type="hidden" name="old_image" value="<?php echo html_escape(@$data->image); ?>">
                                                @if ($data->image)
                                                    <p><img src="{{ asset($data->image) }}" class="image logosmallimg">
                                                    </p>
                                                @endif
                                                @error('image')
                                                    <label class="error">{{ $errors->first('image') }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Event Sort Description<i
                                                        class="text-danger">*</i></label>
                                                <textarea id="sort_description" name="sort_description" class="form-control" id="sort_description">{{ $data->sort_description ?? old('sort_description') }}</textarea>
                                                @error('sort_description')
                                                    <label class="error">{{ $errors->first('sort_description') }}</label>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="description">Event Description<i
                                                        class="text-danger">*</i></label>
                                                <textarea id="description" name="description" class="form-control ckeditor" rows="4" id="description">{{ $data->description ?? old('description') }}</textarea>
                                                @error('description')
                                                    <label class="error">{{ $errors->first('description') }}</label>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
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

            $('#category_1').select2();

            $(window).on('load', function() {
                $('.ckeditor').ckeditor();
            });

            $("#eventForm").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 250
                    },
                    category_1: "required",
                    date: {
                        required: true,
                        date: true
                    },
                    sort_order: "required",
                    image: {
                        required: false,
                        extension: "jpg|png|gif|jpeg",
                    },
                    sort_description: {
                        required: true,
                        maxlength: 250
                    },
                    description: "required",
                },
                messages: {
                    title: {
                        required: "Please Enter Event Title",
                        maxlength: "Maximum 250 characters are allowed"
                    },
                    category_1: "Please Select Event Category",
                    date: {
                        required: "Please Enter Event Date",
                        date: "Please Enter Valid Date"
                    },
                    sort_order: "Please Enter Event Sort Order",
                    image: {
                        extension: "Please upload file in these format only (jpg, jpeg, png, gif)",
                    },
                    sort_description: {
                        required: "Please Enter Event Sort Description",
                        maxlength: "Maximum 250 characters are allowed"
                    },
                    description: "Please Enter Event Description",
                }
            });
            $("body").on("click", ".btn-submit", function(e) {
                if ($("#eventForm").valid()) {
                    $("#eventForm").submit();
                }
            });
        });
    </script>
@endsection
