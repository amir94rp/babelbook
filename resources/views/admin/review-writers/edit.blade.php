@extends('layouts.admin-header-footer')
@section('header')
    <link rel="stylesheet" type="text/css" href="{{asset('admin-template-assets/plugins/dropify/dropify.min.css')}}">
    <link href="{{asset('admin-template-assets/assets/css/users/account-setting.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .general-info .info .upload{border: 0;}
    </style>
@endsection
@section('content')
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="page-header">
                <div class="page-title">
                    <h3>ویرایش</h3>
                </div>
            </div>

            <div class="account-settings-container layout-top-spacing">
                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                {!! Form::model($writer,['method'=>'PATCH' , 'action'=>['AdminReviewWritersController@update',$writer->id],'class'=>'section general-info','id'=>'general-info','files'=>true]) !!}
                                <div class="info">
                                    <h6 class="">ویرایش اطلاعات نویسنده</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-12 col-md-4">
                                                    <div class="upload mt-4 pr-md-4">
                                                        <input type="file" id="input-file-max-fs" class="dropify" data-max-file-size="2M" data-default-file="{{$writer->image->path}}" name="image"/>
                                                        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> آپلود عکس</p>
                                                    </div>
                                                </div>
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="name">نام و نام خانوادگی</label>
                                                                    {!! Form::text('name', null , ['class'=>'form-control mb-4','id'=>'name','placeholder'=>'نام و نام خانوادگی']) !!}
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="url_en_name">نام لاتین [URL]</label>
                                                                    {!! Form::text('url_en_name', null , ['class'=>'form-control mb-4','id'=>'url_en_name','placeholder'=>'نام لاتین']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="description">بیوگرافی</label>
                                                                    {!! Form::textarea('description', null , ['class'=>'form-control','id'=>'description','placeholder'=>'در مورد نویسنده','rows'=>'6']) !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    @if(count($errors) > 0)
                                                        <div class="alert alert-danger" style="direction: ltr;text-align: left;">
                                                            <ul class="mb-0">
                                                                @foreach($errors->all() as $error)
                                                                    <li>{{$error}}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                                <button class="btn btn-info mt-3" type="submit">ویرایش</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <script src="{{asset('admin-template-assets/plugins/dropify/dropify.min.js')}}"></script>
    <script src="{{asset('admin-template-assets/plugins/blockui/jquery.blockUI.min.js')}}"></script>
    <script src="{{asset('admin-template-assets/assets/js/users/account-settings.js')}}"></script>
    <!--  END CUSTOM SCRIPTS FILE  -->
@endsection
