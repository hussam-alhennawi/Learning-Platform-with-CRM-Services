@extends('backEnd.layouts.master')
@section('title','Add Library Project')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('lib_projects.index')}}">References</a> <a href="{{route('lib_projects.create')}}" class="current">Add New Library Project</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>Add New Library Project</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{route('lib_projects.store')}}" name="basic_validate" id="add_userpassword_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="control-group{{$errors->has('title_ar')?' has-error':''}}">
                            <label class="control-label">Arbic Title :</label>
                            <div class="controls">
                                <input type="text" name="title_ar" id="title_ar" value="{{old('title_ar')}}" required>
                                <span class="text-danger" id="title_ar" style="color: red;">{{$errors->first('title_ar')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('title_en')?' has-error':''}}">
                            <label class="control-label">English Title :</label>
                            <div class="controls">
                                <input type="text" name="title_en" id="title_en" value="{{old('title_en')}}" required>
                                <span class="text-danger" id="title_en" style="color: red;">{{$errors->first('title_en')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('study_year')?' has-error':''}}">
                            <label class="control-label">Study Year :</label>
                            <div class="controls">
                                <input type="text" name="study_year" id="study_year" value="{{old('study_year')}}" required>
                                <span class="text-danger" id="study_year" style="color: red;">{{$errors->first('study_year')}}</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Subject :</label>
                            <div class="controls" style="width: 245px;">
                                <select name="subject_id" id="subject_id">
                                    @foreach($subjects as $subject)
                                        <option value="{{$subject->id}}">{{$subject->collage->name_en}} : {{$subject->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Students :</label>
                            <div class="controls" style="width: 245px;">
                                <select name="students[]" multiple>
                                    @foreach($students as $student)
                                        <option value="{{$student->id}}">{{$student->first_name}} {{$student->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Supervisors :</label>
                            <div class="controls" style="width: 245px;">
                                <select name="supervisors[]" multiple>
                                    @foreach($supervisors as $supervisor) 
                                        <option value="{{$supervisor->id}}">{{$supervisor->first_name}} {{$supervisor->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('pdf_file')?' has-error':''}}">
                            <label class="control-label">PDF file :</label>
                            <div class="controls">
                                <input type="file" name="pdf_file" id="pdf_file" value="{{old('pdf_file')}}" accept=".pdf" required>
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