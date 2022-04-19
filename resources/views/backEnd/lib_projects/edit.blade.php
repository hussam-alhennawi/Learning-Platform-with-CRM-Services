@extends('backEnd.layouts.master')
@section('title','Edit Library Project')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('lib_projects.index')}}">Library Projects</a> <a href="#" class="current">Edit Library Project</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Edit Library Project</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{route('lib_projects.update',$lib_project->id)}}" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{method_field("PUT")}}
                                                       
                        <div class="control-group{{$errors->has('title_ar')?' has-error':''}}">
                            <label class="control-label">Arabic Tilte :</label>
                            <div class="controls">
                                <input type="text" name="title_ar" id="title_ar" value="{{$lib_project->title_ar}}" required>
                                <span class="text-danger" id="title_ar" style="color: red;">{{$errors->first('title_ar')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('title_en')?' has-error':''}}">
                            <label class="control-label">English Tilte :</label>
                            <div class="controls">
                                <input type="text" name="title_en" id="title_en" value="{{$lib_project->title_en}}" required>
                                <span class="text-danger" id="title_en" style="color: red;">{{$errors->first('title_en')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('study_year')?' has-error':''}}">
                            <label class="control-label">Study Year :</label>
                            <div class="controls">
                                <input type="text" name="study_year" id="study_year" value="{{$lib_project->study_year}}" required>
                                <span class="text-danger" id="study_year" style="color: red;">{{$errors->first('study_year')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('subject_id')?' has-error':''}}">
                            <label class="control-label">Subject :</label>
                            <div class="controls">
                                <select name="subject_id" style="width: 415px;">
                                    @foreach ($subjects as $subject)
                                        <option value="{{$subject->id}}" {{($lib_project->subject_id == $subject->id)?'selected':''}}>{{$subject->collage->name_en}} : {{$subject->name_en}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="subject_id" style="color: red;">{{$errors->first('subject_id')}}</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Students :</label>
                            <div class="controls" style="width: 245px;">
                                <select name="students[]" multiple>
                                    @foreach($students as $student)
                                        <option value="{{$student->id}}" 
                                            @foreach($lib_project->students as $stud)
                                                @if($student->id == $stud->id)
                                                    selected
                                                @endif
                                            @endforeach>{{$student->first_name}} {{$student->last_name}}</option>
                                    @endforeach
                                </select>
                                {{-- @foreach($students as $student)
                                    <input name="students[]" type="checkbox" value="{{$student->id}}" 
                                    @foreach($lib_project->students as $stud)
                                        @if($student->id == $stud->id)
                                            checked
                                        @endif
                                    @endforeach
                                        >{{$student->first_name}} {{$student->last_name}}<br>
                                @endforeach --}}
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Supervisors :</label>
                            <div class="controls" style="width: 245px;">
                                <select name="supervisors[]" multiple>
                                    @foreach($supervisors as $supervisor) 
                                        <option value="{{$supervisor->id}}"
                                            @foreach($lib_project->supervisors as $super)
                                        @if($supervisor->id == $super->id)
                                            selected
                                        @endif
                                    @endforeach>{{$supervisor->first_name}} {{$supervisor->last_name}}</option>
                                    @endforeach
                                </select>
                                {{-- @foreach($supervisors as $supervisor)
                                    <input name="supervisors[]" type="checkbox" value="{{$supervisor->id}}"
                                    @foreach($lib_project->supervisors as $super)
                                        @if($supervisor->id == $super->id)
                                            checked
                                        @endif
                                    @endforeach
                                        >{{$supervisor->first_name}} {{$supervisor->last_name}}<br>
                                @endforeach --}}
                            </div>
                        </div>                   
                        <div class="control-group">
                            <label class="control-label">PDF file</label>
                            <div class="controls">
                                @if($lib_project->pdf_file === 'null')
                                    <input type="file" name="pdf_file" accept=".pdf"  id="pdf_file" required/>
                                @else
                                    <input type="hidden" name="countOldPDF" value="{{($lib_project->pdf_file === 'null')?0:1}}"/>
                                    <span class="text-danger">{{$errors->first('pdf_file')}}</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="javascript:" rel="{{$lib_project->id}}" rel1="delete-lib-pdf" class="btn btn-danger btn-mini deleteRecord">Delete Old file</a>
                                    <a href="{{Storage::url('PDFfiles/'.$lib_project->pdf_file)}}" target="_blank" class="btn btn-primary btn-mini">Download</a>
                                @endif
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
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        $(".deleteRecord").click(function () {
            var id=$(this).attr('rel');
            var deleteFunction=$(this).attr('rel1');
            swal({
                title:'Are you sure?',
                text:"You won't be able to revert this!",
                type:'warning',
                showCancelButton:true,
                confirmButtonColor:'#3085d6',
                cancelButtonColor:'#d33',
                confirmButtonText:'Yes, delete it!',
                cancelButtonText:'No, cancel!',
                confirmButtonClass:'btn btn-success',
                cancelButtonClass:'btn btn-danger',
                buttonsStyling:false,
                reverseButtons:true
            },function () {
                window.location.href="{{route('management')}}/"+deleteFunction+"/"+id;
            });
        });
    </script>
    
@endsection