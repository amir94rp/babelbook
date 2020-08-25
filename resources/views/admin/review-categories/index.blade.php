@extends('layouts.admin-header-footer')
@section('header')
    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="{{asset('admin-template-assets/assets/css/elements/custom-tree_view.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin-template-assets/assets/css/scrollspyNav.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin-template-assets/plugins/file-upload/file-upload-with-preview.min.css')}}" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->
    <style>
        li > a{
            color: #888ea8;
            margin-right: 15px;
        }
    </style>
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

                                {!! Form::open(['method'=>'POST' , 'action'=>'AdminReviewCategoriesController@store','files'=>true]) !!}
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-6">
                                            <label for="name">نام</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="نام">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="url_en_name">نام لاتین [URL]</label>
                                            <input type="text" class="form-control" id="url_en_name" name="url_en_name" placeholder="نام لاتین">
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
                                    <div class="form-row mb-4">
                                        <div class="form-group col-md-5">
                                            <label for="has_parent">دسته بندی سرشاخه دارد؟</label>
                                            <select id="has_parent" class="form-control" name="has_parent">
                                                <option value="0" selected>خیر</option>
                                                <option value="1">بلی</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-7 d-none">
                                            <label for="parent_id">سرشاخه</label>
                                            <select id="parent_id" class="form-control" name="parent_id">
                                                <option value="null" selected disabled>انتخاب کنید</option>
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">ثبت</button>
                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-0">
                    <div id="treeviewAnimated" class="col-lg-12 layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                        <h4>همه دسته بندی ها</h4>
                                    </div>
                                </div>
                            </div>
                            @php
                                function printAllCategories($categories,$id){
                                    if(! $categories->contains('parent_id',$id)){
                                        return;
                                    }

                                    if ($id == null){
                                        echo "<ul class='file-tree'>";
                                    }else{
                                        echo "<ul>";
                                    }
                                    foreach($categories as $category) {
                                       if($category->parent_id == $id){
                                           if($category->is_parent == 1){
                                                echo "<li class='file-tree-folder'>$category->name";
                                           }else{
                                                echo "<li>$category->name";
                                           }
                                           echo '<a href="'.route("category.edit",$category->id).'"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>';
                                           printAllCategories($categories,$category->id);
                                           echo '</li>';
                                       }
                                    }
                                    echo "</ul>";
                                }
                            @endphp
                            <div class="widget-content widget-content-area">
                                {{printAllCategories($categories,null)}}
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
    <script src="{{asset('admin-template-assets/plugins/treeview/custom-jstree.js')}}"></script>
    <script src="{{asset('admin-template-assets/assets/js/scrollspyNav.js')}}"></script>
    <script src="{{asset('admin-template-assets/plugins/file-upload/file-upload-with-preview.min.js')}}"></script>
    <script>
        let firstUpload = new FileUploadWithPreview('reviewCategoryImage');
        $(document).ready(function () {
            $("#has_parent").on('change',function () {
                let targetElement =$("#parent_id").parent();
                if($(this).val() == 0){
                    targetElement.addClass('d-none');
                }else{
                    targetElement.removeClass('d-none');
                }
            })
        })
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@endsection
