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
                                <a href="{{ url('admin/faq') }}" class="btn btn-success"><i class="fa fa-list"></i> Faq
                                    Lists</a>
                            </div>
                        </div>
                        <form id="faqForm" method="post" action="{{ url('admin/faq') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Select Faq Category<i class="text-danger">*</i></label>
                                            <select name="category_1" id="category_1" class="form-select">
                                                <option value="">Select Category</option>
                                                @if (!empty($level1_categories))
                                                    @foreach ($level1_categories as $l1Key => $l1Value)
                                                        <option value="{{ $l1Value['id'] }}">{{ $l1Value['name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @error('category_1')
                                                <label class="error">{{ $errors->first('category_1') }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="question">Faq Question<i class="text-danger">*</i></label>
                                            <input type="text" name="question" class="form-control"
                                                value="{{ old('question') }}" id="question"
                                                placeholder="Enter Faq Question">
                                            @error('question')
                                                <label class="error">{{ $errors->first('question') }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sort_order">Faq Order<i class="text-danger">*</i></label>
                                            <input type="text" name="sort_order" class="form-control"
                                                value="{{ old('sort_order') }}" id="sort_order"
                                                placeholder="Enter Faq Sort Order"
                                                onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g, '')">
                                            @error('sort_order')
                                                <label class="error">{{ $errors->first('sort_order') }}</label>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="answer">Faq Answer<i class="text-danger">*</i></label>
                                            <textarea id="cke_answer" name="answer" class="form-control ckeditor" rows="4">{{ old('answer') }}</textarea>
                                            @error('answer')
                                                <label class="error">{{ $errors->first('answer') }}</label>
                                            @enderror
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

            $("#faqForm").validate({
                rules: {
                    category_1: "required",
                    sort_order: "required",
                    question: "required",
                    answer: "required",
                },
                messages: {
                    category_1: "Please Select Faq Category",
                    question: "Please Enter Faq Question",
                    answer: "Please Enter Faq Answer",
                    sort_order: "Please Enter Faq Sort Order",
                },
                errorPlacement: function(error, element) {
                    if ($(element).hasClass("form-check-input")) {
                        // error.insertAfter($(element).parent());
                        $(element).closest('.col-sm-6').append(error);
                    } else if ($(element).hasClass("key")) {
                        $('#key-error').append(error);
                    } else if ($(element).hasClass("ckeditor")) {
                        error.insertAfter($('#cke_answer'));
                    } else if ($(element).hasClass("size-input")) {
                        error.insertAfter($(element).parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            $("body").on("click", ".btn-submit", function(e) {
                if ($("#faqForm").valid()) {
                    $("#faqForm").submit();
                }
            });
        });
    </script>
@endsection
