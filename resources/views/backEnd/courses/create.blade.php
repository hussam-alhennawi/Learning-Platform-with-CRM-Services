@extends('backEnd.layouts.master')
@section('title','Add Course')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('courses.index')}}">Courses</a> <a href="{{route('courses.create')}}" class="current">Add New Course</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>Add New Course</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{route('courses.store')}}" name="basic_validate" id="add_userpassword_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="control-group{{$errors->has('category_id')?' has-error':''}}">
                            <label class="control-label">Select Category :</label>
                            <div class="controls">
                                <select name="category_id" style="width: 415px;">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->parentCategory->name}}: {{$category->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="category_id" style="color: red;">{{$errors->first('category_id')}}</span>
                            </div>
                        </div>
                        @role('superadministrator')
                        <div class="control-group{{$errors->has('lecturer_id')?' has-error':''}}">
                            <label class="control-label">Select Lecturer :</label>
                            <div class="controls">
                                <select name="lecturer_id" style="width: 415px;">
                                    @foreach ($lecturers as $lecturer)
                                        <option value="{{$lecturer->id}}">{{$lecturer->first_name}} {{$lecturer->last_name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="lecturer_id" style="color: red;">{{$errors->first('lecturer_id')}}</span>
                            </div>
                        </div>
                        <input type="hidden" name="isAdministrator" value="1"/>
                        @endrole
                        <div class="control-group{{$errors->has('title')?' has-error':''}}">
                            <label class="control-label">Title :</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" value="{{old('title')}}" required>
                                <span class="text-danger" id="title" style="color: red;">{{$errors->first('title')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('description')?' has-error':''}}">
                            <label class="control-label">Description :</label>
                            <div class="controls">
                                <textarea name="description" id="description" value="{{old('description')}}" required></textarea>
                                <span class="text-danger" id="description" style="color: red;">{{$errors->first('description')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('skills')?' has-error':''}}">
                            <label class="control-label">Skills :</label>
                            <div class="controls">
                                <textarea name="skills" id="skills" value="{{old('skills')}}" required></textarea>
                                <span class="text-danger" id="skills" style="color: red;">{{$errors->first('skills')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('level')?' has-error':''}}">
                            <label class="control-label">Level :</label>
                            <div class="controls">
                                <input type="text" name="level" id="level" value="{{old('level')}}" required>
                                <span class="text-danger" id="level" style="color: red;">{{$errors->first('level')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('duration')?' has-error':''}}">
                            <label class="control-label">Duration :</label>
                            <div class="controls">
                                <input type="text" name="duration" id="duration" value="{{old('duration')}}" required>
                                <span class="text-danger" id="duration" style="color: red;">{{$errors->first('duration')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('cost')?' has-error':''}}">
                            <label class="control-label">Cost :</label>
                            <div class="controls">
                                <input type="number" min="0" step="0.01" name="cost" id="cost" value="{{old('cost')}}" required>
                                <span class="text-danger" id="cost" style="color: red;">{{$errors->first('cost')}}</span>
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