@extends('backEnd.layouts.master')
@section('title','Add Lecture')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('lectures.index')}}">Lectures</a> <a href="{{route('lectures.create')}}" class="current">Add New Lecture</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>Add New Lecture</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{route('lectures.store')}}" name="basic_validate" id="add_userpassword_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="control-group{{$errors->has('class_id')?' has-error':''}}">
                            <label class="control-label">Select Class :</label>
                            <div class="controls">
                                <select name="class_id" style="width: 415px;">
                                    @foreach ($classes as $class)
                                <option value="{{$class->id}}">{{$class->subject->collage->name_en}}: {{$class->study_year}}: {{$class->subject->name_en}}-{{$class->type}}, by: {{$class->lecturer->first_name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="class_id" style="color: red;">{{$errors->first('class_id')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('title')?' has-error':''}}">
                            <label class="control-label">Title :</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" value="{{old('title')}}" required>
                                <span class="text-danger" id="title" style="color: red;">{{$errors->first('title')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('date')?' has-error':''}}">
                            <label class="control-label">Date :</label>
                            <div class="controls">
                                <input type="date" name="date" id="date" value="{{old('date')}}" required>
                                <span class="text-danger" id="date" style="color: red;">{{$errors->first('date')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('pdf_file')?' has-error':''}}">
                            <label class="control-label">PDF file :</label>
                            <div class="controls">
                                <input type="file" name="pdf_file" id="pdf_file" value="{{old('pdf_file')}}" accept=".pdf">
                                <span class="text-danger" id="pdf_file" style="color: red;">{{$errors->first('pdf_file')}}</span>
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