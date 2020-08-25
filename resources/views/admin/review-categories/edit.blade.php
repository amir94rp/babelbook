@extends('layouts.admin-header-footer')
@section('header')
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{asset('admin-template-assets/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin-template-assets/plugins/file-upload/file-upload-with-preview.min.css')}}" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
@endsection
@section('content')
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="container">

            <div class="container">

                <div class="page-header">
                    <div class="page-title">
                        <h3>دسته بندی ها</h3>
                    </div>
                </div>

                <div class="row layout-top-spacing">
                    <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>اضافه کردن دسته بندی</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">

                                {!! Form::model($category,['method'=>'PATCH' , 'action'=>['AdminReviewCategoriesController@update',$category->id],'files'=>true]) !!}
                                <div class="form-row mb-4">
                                    <div class="form-group col-md-6">
                                        <label for="name">نام</label>
                                        {!! Form::text('name', null , ['class'=>'form-control','id'=>'name','placeholder'=>'نام']) !!}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="url_en_name">نام لاتین [URL]</label>
                                        {!! Form::text('url_en_name', null , ['class'=>'form-control','id'=>'url_en_name','placeholder'=>'نام لاتین']) !!}
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="custom-file-container" data-upload-id="reviewCategoryImage">
                                        <label>تصویر <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
                                        <label class="custom-file-container__custom-file" >
                                            <input type="file" class="custom-file-container__custom-file__custom-file-input" name="image" accept="image/*">
                                            <span class="custom-file-container__custom-file__custom-file-control"></span>
                                        </label>
                                        <div class="custom-file-container__image-preview"></div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">ویرایش</button>
                                {!! Form::close() !!}

                            </div>
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
    <script src="{{asset('admin-template-assets/plugins/file-upload/file-upload-with-preview.min.js')}}"></script>
    <script>
        let firstUpload = new FileUploadWithPreview('reviewCategoryImage');
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection
