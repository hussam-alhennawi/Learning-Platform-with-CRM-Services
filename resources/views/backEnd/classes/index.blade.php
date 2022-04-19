@extends('backEnd.layouts.master')
@section('title','List Classes')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('classes.index')}}" class="current">Classes</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List Classes</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Lecturer</th>
                        <th>Study Year</th>
                        <th>Semester Number</th>
                        <th>Type</th>
                        <th>Number of Students In Class</th>
                        @if(isset($student))
                            <th>Mark For <a href="{{route('users.show',$student->id)}}">{{$student->full_name()}}</a></th>
                        @endif
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                            <tr class="gradeC">
                                <td>{{$class->subject->name_en}}</td>
                                <td><a href="{{route('users.show',$class->lecturer_id)}}">{{$class->lecturer->full_name()}}</a></td>
                                <td>{{$class->study_year}}</td>
                                <td>{{$class->semester_number}}</td>
                                <td>{{$class->type}}</td>
                                <td>
                                    <?php
                                        $records = [];
                                        foreach ($class->StudentsRegistredAtClass as $reg)
                                        {
                                            if(array_key_exists($reg->student_id.'|'.$reg->class_id,$records))
                                            {
                                                $records [$reg->student_id.'|'.$reg->class_id] ['marks'] .=' , '.$reg->mark;
                                                $records [$reg->student_id.'|'.$reg->class_id] ['student'] = $reg->student;
                                                $records [$reg->student_id.'|'.$reg->class_id] ['class'] = $reg->class;
                                            }
                                            else 
                                            {
                                                $records [$reg->student_id.'|'.$reg->class_id] ['marks'] = $reg->mark;
                                                $records [$reg->student_id.'|'.$reg->class_id] ['student'] = $reg->student;
                                                $records [$reg->student_id.'|'.$reg->class_id] ['class'] = $reg->class;
                                            }
                                        }
                                    ?>
                                    <a href="#myModal{{$class->id}}" data-toggle="modal" class="btn btn-info btn-mini">{{count($records)}}</a>
                                </td>
                                @if(isset($student))
                                    <td>{{$records[$student->id.'|'.$class->id]['marks']}}</td>
                                @endif
                                <td style="text-align: left;">
                                    <a href="{{route('getLecturesByClass',$class->id)}}" class="btn btn-success btn-mini">Lectures</a>
                                    <a href="{{route('classes.edit',$class->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                    <a href="javascript:" rel="{{$class->id}}" rel1="delete-class" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                </td>
                            </tr>
                            <!--Pop Up Model for View Students-->
                            <div id="myModal{{$class->id}}" class="modal hide">
                                <div class="modal-header">
                                    <button data-dismiss="modal" class="close" type="button">×</button>
                                    <h3>{{$class->subject->name_en}} By: <a href="{{route('users.show',$class->lecturer_id)}}">{{$class->lecturer->full_name()}}</a></h3>
                                    <h4>{{count($records)}} Students</h4>
                                </div>
                                <div class="modal-body">
                                    @foreach ($records as $st)
                                        <p class="text-center">{{$st['student']->id}} :<a href="{{route('users.show',$st['student']->id)}}">{{$st['student']->full_name()}}</a> ({{$st['marks']}})</p>
                                    @endforeach
                                </div>
                            </div>
                            <!--Pop Up Model for View Students Details-->
                        @endforeach
                    </tbody>
                </table>
                {{$classes->links()}}
            </div>
        </div>
    </div>
@endsection
@section('jsblock')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/jquery.ui.custom.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/jquery.uniform.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/matrix.js')}}"></script>
    <script src="{{asset('js/matrix.tables.js')}}"></script>
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
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
                window.location.href="{{route('management')}}"+deleteFunction+"/"+id;
            });
        });
    </script>
    
@endsection