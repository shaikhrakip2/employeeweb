@extends('admin.layouts.main')
@section('header_scripts')
<script src="{{VENDOR}}ckeditor/ckeditor/ckeditor.js"></script>
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
              <a href="{{ url('admin/gallery') }}" class="btn btn-success"><i class="fa fa-list"></i> Photo Gallery Lists</a>
            </div>
          </div>
          <form id="galleryForm" method="post" action="{{ url('admin/gallery', ['id' => $data->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="card-body">
              <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Details</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Images</button>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="name">Name<i class="text-danger">*</i></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name',$data->name) }}" id="name" placeholder="Enter Name">
                        <label class="error">{{ $errors->first('name') }}</label>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="sort_order">Sort Order<i class="text-danger">*</i></label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order',$data->sort_order) }}" id="sort_order" placeholder="Enter Sort Order">
                        <label class="error">{{ $errors->first('sort_order') }}</label>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="default_image">Default Image</label>
                        <input type="file" class="form-control" name="default_image" id="default_image">
                        <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                        <input type="hidden" name="old_image" value="<?php echo html_escape(@$data->default_image); ?>">
                        @if($data->default_image)
                        <p><img src="{{asset($data->default_image)}}" class="image logosmallimg"></p>
                        @endif
                        <label class="error">{{ $errors->first('image') }}</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="row">
                    <div>
                      <div class="form-group row mx-0">
                        <div class="col-md-12 px-0 py-2 text-end">
                          <input type="button" name="add_media" data-lang="image" value="Add Image" class="btn btn-primary add_media">
                        </div>
                      </div>
                      <div class="form-group row mx-0">
                        <div class="col-md-12 px-0" id="objectives">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th>Image</th>
                                <th>Sort Order</th>
                                <th style="width: 100px;">Action</th>
                              </tr>
                            </thead>
                            <tbody id="media_data">
                              @if (!empty($media))
                              @foreach ($media as $mkey => $mvalue)
                              <tr id="path-row-image_{{ $mkey }}">
                                <td class="form-group mb-0">
                                  <a href="{{ asset($mvalue['image'] ?? $mvalue['old_media']) }}" target="_blank">
                                    <img class="img-fluid border border-dark p-1 rounded-circle" style="width: 40px;height: 40px;" src="{{ asset($mvalue['image'] ?? $mvalue['old_media']) }}">
                                    <input type="hidden" name="image[{{ $mkey }}][old_media]" value="{{ $mvalue['image'] ?? null }}" />
                                  </a>
                                  <input type="file" name="image[{{ $mkey }}][media]" class="{{ 'image' == 'image' ? 'image_content' : 'video_content' }}" accept="image/*" />
                                </td>
                                <td class="form-group mb-0">
                                  <input type="number" name="image[{{ $mkey }}][sort_order]" class="form-control text_content" value="{{ $mvalue['sort_order'] }}" />
                                </td>
                                <td>
                                  <span class="btn btn-danger btn-sm remove_media_dynamic" cid="image_{{ $mkey }}"><i class="fa fa-trash"></i></span>
                                </td>
                              </tr>
                              @endforeach
                              @endif
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <input type="submit" name="submit" value="Submit" class="btn btn-submit btn-primary pull-right">
              </div>
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
    var image_row = $('#media_data tr').length;

    $('.add_media').on('click', function() {
      var lang_id = $(this).data('lang');

      var html = `
     <tr id="path-row-${lang_id}_${image_row}">
     <td class="form-group mb-0">
         <input type="file" name="${lang_id}[${image_row}][media]" class="form-control ${lang_id == 'image' ? 'image_content' : 'video_content'}" accept="image/*" required/>
     </td>
     <td class="form-group mb-0">
         <input type="number" name="${lang_id}[${image_row}][sort_order]" class="form-control text_content" required/>
     </td>
     <td>
         <span class="btn btn-danger btn-sm remove_media_dynamic" cid="${lang_id}_${image_row}"><i class="fa fa-trash"></i></span>
     </td>
     </tr>`;

      $('#media_data').append(html);
      image_row++;
    });

    $(document).on('click', '.remove_media_dynamic', function() {
      var id = $(this).attr('cid');
      $('#path-row-' + id).remove();
    });

    // jquery validation    
    $("#galleryForm").validate({
      rules: {
        name: "required",
        sort_order: "required",
        default_image: {
          required: false,
          extension: "jpg|png|gif|jpeg",
        },

      },
      messages: {
        name: "Please Enter Name",
        sort_order: "Please Enter  Order",
        default_image: {
          required: "Please Select Photo",
          extension: "Please upload file in these format only (jpg, jpeg, png, gif)",
        },

      }
    });
    $("body").on("click", ".btn-submit", function(e) {
      if ($("#galleryForm").valid()) {
        $("#galleryForm").submit();
      }
    });
  });
</script>
@endsection