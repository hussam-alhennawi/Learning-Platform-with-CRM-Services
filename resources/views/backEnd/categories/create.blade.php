@extends('backEnd.layouts.master')
@section('title','Add Category')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('categories.index')}}">Categories</a> <a href="{{route('categories.create')}}" class="current">Add New Category</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>Add New Category</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{route('categories.store')}}" name="basic_validate" id="add_userpassword_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="control-group{{$errors->has('name')?' has-error':''}}">
                            <label class="control-label">Name :</label>
                            <div class="controls">
                                <input type="text" name="name" id="name" value="{{old('name')}}" required>
                                <span class="text-danger" id="name" style="color: red;">{{$errors->first('name')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('parent_id')?' has-error':''}}">
                            <label class="control-label">Select Parent Category :</label>
                            <div class="controls">
                                <select name="parent_id" style="width: 415px;">
                                    <option value="">Base Ctegory</option>
                                    @foreach ($categories as $cate)
                                        <option value="{{$cate->id}}">{{$cate->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="parent_id" style="color: red;">{{$errors->first('parent_id')}}</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Image</label>
                            <div class="controls">
                                <input type="file" name="image" accept=".jpg, .jpeg, .png" id="image"/>
                                <span class="text-danger">{{$errors->first('image')}}</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="control-label"></label>
                            <div class="controls">
                                <input type="submit" value="Add New" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('jsblock')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.custom.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.uniform.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/matrix.js') }}"></script>
    <script src="{{ asset('js/matrix.form_validation.js') }}"></script>
    <script src="{{ asset('js/matrix.tables.js') }}"></script>
    <script src="{{ asset('js/matrix.popover.js') }}"></script>
@endsection