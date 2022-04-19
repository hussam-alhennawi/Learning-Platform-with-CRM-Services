@extends('backEnd.layouts.master')
@section('title','Edit Topic')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('topics.index')}}">Topics</a> <a href="#" class="current">Edit Topic</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Edit Topic</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{route('topics.update',$topic->id)}}" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{method_field("PUT")}}
                            
                            <div class="control-group{{$errors->has('course_id')?' has-error':''}}">
                                <label class="control-label">Select Course :</label>
                                <div class="controls">
                                    <select name="course_id" style="width: 415px;">
                                        @foreach ($courses as $course)
                                            <option value="{{$course->id}}" {{($topic->course_id == $course->id)?'selected':''}}>{{$course->title}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="course_id" style="color: red;">{{$errors->first('course_id')}}</span>
                                </div>
                            </div>
                        <div class="control-group{{$errors->has('name')?' has-error':''}}">
                            <label class="control-label">Name :</label>
                            <div class="controls">
                                <input type="text" name="name" id="name" value="{{$topic->name}}" required>
                                <span class="text-danger" id="name" style="color: red;">{{$errors->first('name')}}</span>
                            </div>
                        </div>                           
                        <div class="control-group{{$errors->has('description')?' has-error':''}}">
                            <label class="control-label">Description :</label>
                            <div class="controls">
                                <textarea name="description" id="description" required>{{$topic->description}}</textarea>
                                <span class="text-danger" style="color: red;">{{$errors->first('description')}}</span>
                            </div>
                        </div> 
                            <div class="control-group">
                                <label for="control-label"></label>
                                <div class="controls">
                                    <input type="submit" value="Update" class="btn btn-success">
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