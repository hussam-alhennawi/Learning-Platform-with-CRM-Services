@extends('backEnd.layouts.master')
@section('title','Edit Lecture')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('lectures.index')}}">Lectures</a> <a href="#" class="current">Edit Lecture</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Edit Lecture</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{route('lectures.update',$lecture->id)}}" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{method_field("PUT")}}
                            <input type="hidden" name="class_id" value="{{$lecture->class_id}}"/>
                            {{-- <div class="control-group{{$errors->has('class_id')?' has-error':''}}">
                                <label class="control-label">Select Class :</label>
                                <div class="controls">
                                    <select name="class_id" style="width: 415px;">
                                        @foreach ($classes as $class)
                                            <option value="{{$class->id}}" {{($lecture->class_id == $class->id)?'selected':''}}>{{$class->subject->collage->name_en}}: {{$class->study_year}}: {{$class->subject->name_en}}-{{$class->type}}, by: {{$class->lecturer->first_name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="class_id" style="color: red;">{{$errors->first('class_id')}}</span>
                                </div>
                            </div>                             --}}
                        <div class="control-group{{$errors->has('title')?' has-error':''}}">
                            <label class="control-label">Tilte :</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" value="{{$lecture->title}}" required>
                                <span class="text-danger" id="title" style="color: red;">{{$errors->first('title')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('date')?' has-error':''}}">
                            <label class="control-label">Date :</label>
                            <div class="controls">
                                <input type="date" name="date" id="date" value="{{$lecture->date}}" required>
                                <span class="text-danger" id="date" style="color: red;">{{$errors->first('date')}}</span>
                            </div>
                        </div>                            
                        <div class="control-group">
                            <label class="control-label">PDF file</label>
                            <div class="controls">
                                @if(!$lecture->pdf_file)
                                    <input type="file" name="pdf_file" accept=".pdf"  id="pdf_file"/>
                                @else
                                    <span class="text-danger">{{$errors->first('pdf_file')}}</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="javascript:" rel="{{$lecture->id}}" rel1="delete-lec-pdf" class="btn btn-danger btn-mini deleteRecord">Delete Old file</a>
                                    <a href="{{Storage::url('PDFfiles/'.$lecture->pdf_file)}}" target="_blank" class="btn btn-primary btn-mini">Download</a>
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