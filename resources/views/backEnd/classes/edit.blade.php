@extends('backEnd.layouts.master')
@section('title','Edit Class')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('classes.index')}}">Classs</a> <a href="#" class="current">Edit Class</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Edit Class</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{route('classes.update',$class->id)}}" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{method_field("PUT")}}
                            
                            <div class="control-group{{$errors->has('subject_id')?' has-error':''}}">
                                <label class="control-label">Select Subject :</label>
                                <div class="controls">
                                    <select name="subject_id" style="width: 415px;">
                                        @foreach ($subjects as $subject)
                                            <option value="{{$subject->id}}" {{($class->subject_id == $subject->id)?'selected':''}}>{{$subject->name_en}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="subject_id" style="color: red;">{{$errors->first('subject_id')}}</span>
                                </div>
                            </div>
                            <div class="control-group{{$errors->has('lecturer_id')?' has-error':''}}">
                                <label class="control-label">Select Lecturer :</label>
                                <div class="controls">
                                    <select name="lecturer_id" style="width: 415px;">
                                        @foreach ($lecturers as $lecturer)
                                            <option value="{{$lecturer->id}}" {{($class->lecturer_id == $lecturer->id)?'selected':''}}>{{$lecturer->first_name}} {{$lecturer->last_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="lecturer_id" style="color: red;">{{$errors->first('lecturer_id')}}</span>
                                </div>
                            </div>
                            
                        <div class="control-group{{$errors->has('study_year')?' has-error':''}}">
                            <label class="control-label">Study year :</label>
                            <div class="controls">
                                <input type="text" name="study_year" id="study_year" value="{{$class->study_year}}" required>
                                <span class="text-danger" id="study_year" style="color: red;">{{$errors->first('study_year')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('semester_number')?' has-error':''}}">
                            <label class="control-label">Semester :</label>
                            <div class="controls">
                                <input type="number" min="1" max="3" name="semester_number" id="semester_number" value="{{$class->semester_number}}" required>
                                <span class="text-danger" id="semester_number" style="color: red;">{{$errors->first('semester_number')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('type')?' has-error':''}}">
                            <label class="control-label">Type :</label>
                            <div class="controls" style="width: 245px;">
                                <select name="type">
                                    <option value="practical" {{($class->type == 'practical')?'selected':''}}>practical</option>
                                    <option value="theoretical" {{($class->type == 'theoretical')?'selected':''}}>Theoretical</option>
                                </select>
                                <span class="text-danger" id="type" style="color: red;">{{$errors->first('type')}}</span>
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