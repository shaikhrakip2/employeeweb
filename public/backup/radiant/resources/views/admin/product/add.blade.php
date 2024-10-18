@extends('admin.layouts.main')
@section('header_scripts')
<script src="{{ ASSETS }}ckeditor/ckeditor.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@stop
@section('content')
<section class="content">
   <div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-header d-flex justify-content-end">
               <div class="card-title pull-right">
                  <a href="{{ url('admin/product') }}" class="btn btn-success"><i class="fa fa-list"></i>
                  Product Lists</a>
               </div>
            </div>
            <form id="accessoryForm" method="post" action="{{ url('admin/product') }}"
               enctype="multipart/form-data">
               @csrf
               <div class="card-body">
                  <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                     <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                           data-bs-target="#home" type="button" role="tab" aria-controls="home"
                           aria-selected="true">Details</button>
                     </li>
                     <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Specification-tab" data-bs-toggle="tab"
                           data-bs-target="#Specification" type="button" role="tab"
                           aria-controls="Specification" aria-selected="false">Category</button>
                     </li>
                     <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                           data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                           aria-selected="false">Images</button>
                     </li>
                  </ul>
                  <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="home" role="tabpanel"
                        aria-labelledby="home-tab">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="name">Product Name<i class="text-danger">*</i></label>
                                 <input type="text" name="name" class="form-control"
                                    value="{{ old('name') }}" id="name"
                                    placeholder="Enter name">
                                 <label class="error">{{ $errors->first('name') }}</label>
                              </div>
                           </div>
                                          
                          
                           <div class="row">
                              <div class="col">
                                 <div class="form-group">
                                 <label for="is_trending">Is Trending Product(For Home Page)<i class="text-danger">*</i></label>
                                    <select name="is_trending" id="is_trending" class="form-control">
                                       <option value="">Select Is Trending Product Or Not</option>
                                       <option value="1">Yes</option>
                                       <option value="0">No</option>
                                    </select>
                                    <label class="error">{{ $errors->first('is_trending') }}</label>
                                 </div>
                              </div>
                              <div class="col">
                                 <div class="form-group">
                                 <label for="is_top">Is Top Product(For Home Page)<i class="text-danger">*</i></label>
                                    <select name="is_top" id="is_top" class="form-control">
                                       <option value="">Select Is Top Product Or Not</option>
                                       <option value="1">Yes</option>
                                       <option value="0">No</option>
                                    </select>
                                    <label class="error">{{ $errors->first('is_top') }}</label>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                              <label for="default_image">Image<i class="text-danger">*</i></label>
                                 <input type="file" class="form-control" name="default_image"
                                    id="default_image" accept="image/*">
                                 <p><small class="text-success">Allowed Types: gif, jpg, png,
                                    jpeg</small>
                                 </p>
                                 <input type="hidden" name="old_image" value="<?php echo html_escape(@$data->default_image); ?>">
                                
                                 <label class="error">{{ $errors->first('default_image') }}</label>
                              </div>
                           </div>
                           <div class="col">
                              <div class="form-group">
                                 <label for="sort_order">Sort Order<i class="text-danger">*</i></label>
                                 <input type="number" name="sort_order" class="form-control"
                                    value="{{ old('sort_order') }}" id="sort_order"
                                    placeholder="Enter Sort Order">
                                 <label class="error">{{ $errors->first('sort_order') }}</label>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="sort_description">Sort Description<i
                                    class="text-danger">*</i></label>
                                    <textarea id="sort_description" name="sort_description" class="form-control" rows="2">{{ old('sort_description') }}</textarea>
                                 <label class="error">{{ $errors->first('sort_description') }}</label>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label for="description">Description<i
                                    class="text-danger">*</i></label>
                                    <textarea id="description" name="description" class="form-control ckeditor" rows="5">{{ old('description') }}</textarea>
                                 <label class="error">{{ $errors->first('description') }}</label>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="Specification" role="tabpanel"
                        aria-labelledby="Specification-tab">
                        <!-- Get categories -->
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                              <label for="main_parent_id">Category<i class="text-danger">*</i></label><br/>
                              <select name="main_parent_id"  id="main_parent_id" class="w-100 form-control getsubcategroy">
                                 <option value="">Select Category</option>
                                 @foreach ($parcat as $key => $pcat) 
                                 <option value="{{ $pcat['id'] }}">{{ $pcat['name'] }}</option>
                                 @endforeach
                              </select>
                              <div class="" style="margin-top:3px;">
                                 <?php 
                                    $category_id = old('category_id'); 
                                    $category_list = '';
                                    $procategory = [];
                                    if(!empty($category_id)){
                                      $asupp = explode(',',$category_id);
                                      $procategory = App\Models\Category::select('id','name')->wherein('id',$asupp)->get()->toArray(); 
                                    }
                                    foreach ($procategory as $key => $value) {
                                      $category_list.= '<div class="col-md-12 cat_'.$value['id'].'">'.$value['name'].' <span class="removecat" cid="'.$value['id'].'"><i class="fa fa-trash"></i></span></div>';
                                    } 
                                    ?>
                                 <input type="hidden" name="category_id" id="category_id" value="<?=old('category_id')?>">
                                 <div class="form-control minheightdiv" id="product_category_id"><?=$category_list?></div>
                              </div>
                              <div class="row">
                                 <label id="category_id-error" class="error" for="category_id"></label>
                              </div>
                                 <label class="error">{{ $errors->first('category_id') }}</label> 
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="profile" role="tabpanel"
                        aria-labelledby="profile-tab">
                        <div class="row">
                           <div>
                              <div class="form-group row mx-0">
                                 <div class="col-md-12 px-0 py-2 text-end">
                                    <input type="button" name="add_media" data-lang="image"
                                       value="Add Image" class="btn btn-primary add_media">
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
                                                <a href="{{ asset($mvalue['image'] ?? $mvalue['old_media']) }}"
                                                   target="_blank">
                                                <img class="img-fluid border border-dark p-1 rounded-circle"
                                                   style="width: 40px;height: 40px;"
                                                   src="{{ asset($mvalue['image'] ?? $mvalue['old_media']) }}">
                                                <input type="hidden"
                                                   name="image[{{ $mkey }}][old_media]"
                                                   value="{{ $mvalue['image'] ?? null }}" />
                                                </a>
                                                <input type="file"
                                                   name="image[{{ $mkey }}][media]"
                                                   class="{{ 'image' == 'image' ? 'image_content' : 'video_content' }}"
                                                   accept="image/*" />
                                             </td>
                                             <td class="form-group mb-0">
                                                <input type="number"
                                                   name="image[{{ $mkey }}][sort_order]"
                                                   class="form-control text_content"
                                                   value="{{ $mvalue['sort_order'] }}" />
                                             </td>
                                             <td>
                                                <span
                                                   class="btn btn-danger btn-sm remove_media_dynamic"
                                                   cid="image_{{ $mkey }}"><i
                                                   class="fa fa-trash"></i></span>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
   
   //    $('#main_parent_id').select2();
   
   $('#main_parent_id').select2({
            placeholder: "Select Any Category",
            width: 'resolve',
            selectionCssClass: 'form-select p-2',
            closeOnSelect: false,
            allowClear: true
        });
    
   
   
   // Manage categories
        $('.getsubcategroy').on('change', function() { 
        var catid = $('#category_id').val();
        var pcatid = $("#main_parent_id option:selected").val();
        if(pcatid!=''){
        var str = $('#category_id').val().split(',');
        if ($.inArray(pcatid, str) !== -1) {
        alert('Category allready added!!!');
        return false;
        }else{
        if(catid==''){
        catid = $("#main_parent_id option:selected").val();
        }else{
        catid = catid+','+$("#main_parent_id option:selected").val();
        }      
        var html = '<div class="col-md-12 cat_'+pcatid+'">'+ $("#main_parent_id option:selected").text()+' <span class="removecat" cid="'+pcatid+'"><i class="fa fa-trash"></i></span></div>';
        $('#category_id').val(catid);
        $('#product_category_id').append(html);
        }
        }
        });
   
   $('#product_category_id').delegate('.removecat', 'click', function() { 
   var pid = $(this).attr('cid');
   
   
   $('.cat_'+pid).remove();
   var ncat = '';
   var str = $('#category_id').val().split(',');
   $.each(str, function(key,value) {
   if (pid!=value) {
   ncat = value+','+ncat;
   }
   }); 
   var lastChar = ncat.slice(-1);
   if (lastChar == ',') {
   ncat = ncat.slice(0, -1);
   }
   $('#category_id').val(ncat);
   });
   
   
   
   
   
   
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
   
   
   
    
       // Trigger the "Show Types" button click after appending the existing data
       $('#show-types').trigger('click');
   
   
   
       $("#accessoryForm").validate({
           rules: {
               category_id: {
                   required: true,
               },
               name: {
                   required: true,
               },
               sort_order: {
                   required: true,
               },
               measurment: {
                   required: true,
               },
               description: {
                   required: true,
               },
               price: {
                   required: true,
                   number: true,
                   pattern: /^\d+(\.\d{1,2})?$/, // Allows up to two decimal places
               },
               is_top: "required",
               is_trending: "required",
           },
           messages: {
               category_id: "Please Select Category",
               name: "Please Enter Name",
               description: "Please Enter Description",
               measurment: "Please Enter Product Measurment",
               sort_order: "Please Enter Sort Order",
               price: {
                   required: "Please Enter Price",
                   number: "Please enter a valid number",
                   pattern: "Please enter a valid number with up to two decimal places",
               },
               is_top: "Please Select Is Top Product",
               is_trending: "Please Select Is Trending Product",
           }
       });
   
       $("body").on("click", ".btn-submit", function(e) {
           if ($("#accessoryForm").valid()) {
               $("#accessoryForm").submit();
           }
       });
   });
</script>
@endsection