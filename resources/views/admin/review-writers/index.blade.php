@extends('layouts.admin-header-footer')
@section('header')
    <link rel="stylesheet" type="text/css" href="{{asset('admin-template-assets/plugins/dropify/dropify.min.css')}}">
    <link href="{{asset('admin-template-assets/assets/css/users/account-setting.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('admin-template-assets/assets/css/forms/theme-checkbox-radio.css')}}">
    <link href="{{asset('admin-template-assets/assets/css/tables/table-basic.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .link-btn{
            background-color: transparent;
            border: 0;
            color: #888ea8;
        }
        .general-info .info .upload{border: 0;}
    </style>
@endsection
@section('content')
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="page-header">
                <div class="page-title">
                    <h3>نویسندگان</h3>
                </div>
            </div>

            <div class="account-settings-container layout-top-spacing">
                <div class="account-content">
                    <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                {!! Form::open(['method'=>'POST' , 'action'=>'AdminReviewWritersController@store','class'=>'section general-info','id'=>'general-info','files'=>true]) !!}
                                    <div class="info">
                                        <h6 class="">اضافه کردن نویسنده</h6>
                                        <div class="row">
                                            <div class="col-lg-11 mx-auto">
                                                <div class="row">
                                                    <div class="col-xl-2 col-lg-12 col-md-4">
                                                        <div class="upload mt-4 pr-md-4">
                                                            <input type="file" id="input-file-max-fs" class="dropify" data-max-file-size="2M" name="image"/>
                                                            <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> آپلود عکس</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                        <div class="form">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="name">نام و نام خانوادگی</label>
                                                                        <input type="text" class="form-control mb-4" id="name" name="name" placeholder="نام و نام خانوادگی">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="url_en_name">نام لاتین [URL]</label>
                                                                        <input type="text" class="form-control mb-4" id="url_en_name" placeholder="نام لاتین" name="url_en_name">
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="description">بیوگرافی</label>
                                                                        <textarea class="form-control" id="description" placeholder="در مورد نویسنده" rows="6" name="description"></textarea>
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
                                                    <button class="btn btn-info mt-3" type="submit">ثبت</button>
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

            <div class="row mt-2">
                <div id="tableProgress" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-header">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                    <h4>لیست نویسندگان</h4>
                                </div>
                            </div>
                        </div>
                        <div class="widget-content widget-content-area">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>تصویر</th>
                                        <th> نام </th>
                                        <th>بیوگرافی</th>
                                        <th class="text-center">عمل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reviewWriters as $writer)
                                        <tr>
                                            <td class="text-center">{{$writer->id}}</td>
                                            <td class="text-center">
                                                @if($writer->image)
                                                    <img src="{{$writer->image->path}}" alt="" width="100px">
                                                @endif
                                            </td>
                                            <td>{{$writer->name}}</td>
                                            <td>
                                                {{ \Illuminate\Support\Str::limit($writer->description, 150, $end='...')}}
                                            </td>
                                            <td class="text-center">
                                                <ul class="table-controls">
                                                    <li><a href="{{route('writer.edit',$writer->id)}}"  data-toggle="tooltip" data-placement="top" title="ویرایش"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a></li>
                                                    <li>
                                                        {!! Form::open(['method'=>'DELETE' , 'action'=>['AdminReviewWritersController@destroy',$writer->id], 'class'=>'d-inline']) !!}
                                                        <button type="submit" class="link-btn" data-toggle="tooltip" data-placement="top" title="حذف"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
                                                        {!! Form::close() !!}
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
    <script>
        checkall('todoAll', 'todochkbox');
        $('[data-toggle="tooltip"]').tooltip()
    </script>
    <!--  END CUSTOM SCRIPTS FILE  -->
@endsection
