@extends('layouts.admin-header-footer')
@section('header')
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{asset('admin-template-assets/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('admin-template-assets/plugins/dropify/dropify.min.css')}}">
    <link href="{{asset('admin-template-assets/plugins/flatpickr/flatpickr.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-template-assets/plugins/flatpickr/custom-flatpickr.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('admin-template-assets/plugins/tagInput/tags-input.css')}}" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tiny.cloud/1/xoqfsa3eirnsu48g28dfa6bdys098snu4mn3tazllg4vmg13/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        .tags-input-wrapper .tag{padding: 7px 9px 4px 3px;}
    </style>
    <!--  END CUSTOM STYLE FILE  -->
@endsection
@section('content')
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="container">
            <div class="container">

                <div class="page-header">
                    <div class="page-title">
                        <h3>اضافه کردن Review جدید</h3>
                    </div>
                </div>

                <div id="description" class="row layout-spacing layout-top-spacing">

                    <div class="col-lg-12 col-12 mb-3">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>اضافه کردن</h4>
                                    </div>
                                </div>
                            </div>
                            {!! Form::open(['method'=>'POST' , 'action'=>'AdminReviewsController@store','id'=>'createNewReviewForm','files'=>true]) !!}
                            <input type="hidden" name="published" id="published" value="1">
                            <div class="widget-content widget-content-area">
                                <div class="form-group mb-4">
                                    <label for="title">عنوان</label>
                                    <input type="text" class="form-control" id="title" name="title">
                                </div>

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-6">
                                        <label for="review_writer_id">نویسنده</label>
                                        <select class="form-control" name="review_writer_id" id="review_writer_id">
                                            <option value="null" disabled selected>انتخاب کنید</option>
                                            @foreach($writers as $writer)
                                                <option value="{{$writer->id}}">{{$writer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="review_category_id">دسته بندی</label>
                                        <select class="form-control" name="review_category_id" id="review_category_id">
                                            <option value="null" disabled selected>انتخاب کنید</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-5">
                                        <label for="review_grid_image">تصویر مربع</label>
                                        <input type="file" id="review_grid_image" class="dropify" data-max-file-size="2M" name="review_grid_image"/>
                                    </div>

                                    <div class="form-group col-md-7">
                                        <label for="review_detail_image">تصویر صفحه Review</label>
                                        <input type="file" id="review_detail_image" class="dropify" data-max-file-size="2M" name="review_detail_image"/>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="description">توضیحات</label>
                                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="tags">تگ</label>
                                    <input type="text" class="form-control" id="tags" name="tags">
                                    <label class="mt-3" for="is_tags_visible"><input id="is_tags_visible" name="is_tags_visible" type="checkbox">   تگ ها نمایش داده شوند</label>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4 form-group mb-0">
                                        <input id="publish_date" name="publish_date" class="form-control flatpickr flatpickr-input active" style="direction: ltr;text-align: right;" type="text" placeholder="انتخاب تاریخ">
                                    </div>
                                </div>

                                @if(count($errors) > 0)
                                    <div class="alert alert-danger mt-5" style="direction: ltr;text-align: left;">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="text-right mt-5">
                                    <button class="btn btn-outline-info" id="btnPublishOnDate" type="button">انتشار در زمان تعیین شده</button>
                                    <button class="btn btn-success" id="btnPublishNow" type="submit">همین الان منتشر کن</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  END CONTENT AREA  -->
@endsection
@section('footer')
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{asset('admin-template-assets/assets/js/scrollspyNav.js')}}"></script>
    <script src="{{asset('admin-template-assets/plugins/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('admin-template-assets/plugins/flatpickr/flatpickr.js')}}"></script>
    <script src="{{asset('admin-template-assets/plugins/tagInput/tags-input.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            let instance = new TagsInput({
                selector: 'tags'
            });

            let f2 = flatpickr(document.getElementById('publish_date'), {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today"
            });

            tinymce.init({
                font_formats:"diroz",
                selector: 'textarea',
                plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak directionality',
                toolbar_mode: 'floating',
            });

            $('.dropify').dropify({
                messages: { 'default': 'Click to Upload or Drag n Drop', 'remove':  '<i class="flaticon-close-fill"></i>', 'replace': 'Upload or Drag n Drop' }
            });

            $("#btnPublishOnDate").on('click',function () {
                $("#published").val(0);
                $("#createNewReviewForm").submit();
            });
        })
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection




