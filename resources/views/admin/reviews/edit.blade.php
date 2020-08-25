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
                        <h3>ویرایش Review </h3>
                    </div>
                </div>

                <div id="description" class="row layout-spacing layout-top-spacing">

                    <div class="col-lg-12 col-12 mb-3">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>ویرایش</h4>
                                    </div>
                                </div>
                            </div>
                            {!! Form::model($review,['method'=>'PATCH' , 'action'=>['AdminReviewsController@update',$review->id],'id'=>'createNewReviewForm','files'=>true]) !!}
                            <input type="hidden" name="published" id="published" value="1">
                            <div class="widget-content widget-content-area">
                                <div class="form-group mb-4">
                                    <label for="title">عنوان</label>
                                    {!! Form::text('title', null , ['class'=>'form-control','id'=>'title']) !!}
                                </div>

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-6">
                                        <label for="review_writer_id">نویسنده</label>
                                        {!! Form::select('review_writer_id',$writers, null , ['class'=>'form-control','id'=>'review_writer_id']) !!}
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="review_category_id">دسته بندی</label>
                                        {!! Form::select('review_category_id',$categories, null , ['class'=>'form-control','id'=>'review_category_id']) !!}
                                    </div>
                                </div>

                                <div class="form-row mb-3">
                                    <div class="form-group col-md-5">
                                        <label for="review_grid_image">تصویر مربع</label>
                                        <input type="file" id="review_grid_image" class="dropify" data-max-file-size="2M" name="review_grid_image" @if($review->image) data-default-file="{{'/images/reviews/grid/'.$review->image->getOriginal('path')}}" @endif/>
                                    </div>

                                    <div class="form-group col-md-7">
                                        <label for="review_detail_image">تصویر صفحه Review</label>
                                        <input type="file" id="review_detail_image" class="dropify" data-max-file-size="2M" name="review_detail_image" @if($review->image) data-default-file="{{'/images/reviews/detail/'.$review->image->getOriginal('path')}}" @endif/>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="description">توضیحات</label>
                                    {!! Form::textarea('description', null , ['class'=>'form-control','id'=>'description']) !!}
                                </div>

                                <div class="form-group mb-4">
                                    <label for="tags">تگ</label>
                                    <input type="text" name="tags" id="tags" class="form-control">
                                    <label class="mt-3" for="is_tags_visible">{!! Form::checkbox('is_tags_visible', null , $review->is_tags_visible > 0 ? 1 : 0, ['id'=>'is_tags_visible']) !!}   تگ ها نمایش داده شوند</label>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-4 form-group mb-0">
                                        {!! Form::text('publish_date', null , ['class'=>'form-control flatpickr flatpickr-input active','id'=>'publish_date','placeholder'=>'انتخاب تاریخ','style'=>'direction: ltr;text-align: right;']) !!}
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
                                    <button class="btn btn-success" id="btnPublishNow" type="submit">ویرایش و انتشار</button>
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

            let reviewTags = new TagsInput({
                selector: 'tags'
            });
            reviewTags.addData({!! "['".implode("','", $review->tags)."']" !!});

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




