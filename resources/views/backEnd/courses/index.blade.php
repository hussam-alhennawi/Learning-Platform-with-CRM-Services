@extends('backEnd.layouts.master')
@section('title','List Courses')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('courses.index')}}" class="current">Courses</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List Courses</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Lecturer</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Skills</th>
                        <th>Level</th>
                        <th>Duration</th>
                        <th>Cost</th>
                        <th>Rate</th>
                        <th>Students Requestes</th>
                        <th>Topics</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            
                            <tr class="gradeC">
                                <td> 
                                    @if($course->image)
                                    <div class="text-center" style="margin:5px;">
                                        <img src="{{url('/photos/courses')}}/{{$course->image}}" width="50" alt="course image">
                                    </div>
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{$course->category->name}}</td>
                                <td><a href="{{route('users.show',$course->lecturer_id)}}">{{$course->lecturer->full_name()}}</a></td>
                                <td>{{$course->title}}</td>
                                <td>{{$course->description}}</td>
                                <td>{{$course->skills}}</td>
                                <td>{{$course->level}}</td>
                                <td>{{$course->duration}}</td>
                                <td>{{$course->cost}}</td>
                                <td>
                                    ({{$course->rate}}) <a href="#myRateModal{{$course->id}}" data-toggle="modal" class="btn btn-info btn-mini"> {{$course->AcceptedStudents()->count()}} rates</a>
                                </td>
                                <td>
                                    <a href="{{route('courses.courseRequests',$course->id)}}" class="btn btn-info btn-mini">{{$course->RegisteredStudents()->count()}} requests</a>
                                </td>
                                <td>
                                    <a href="{{route('getTopicsByCourse',$course->id)}}" class="btn btn-primary btn-mini">{{$course->topics()->count()}} Topics</a>
                                </td>
                                <td style="text-align: left;">
                                    <a href="{{route('courses.edit',$course->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                    <a href="javascript:" rel="{{$course->id}}" rel1="delete-course" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                </td>
                            </tr>
                            <!--Pop Up Model for View User-->
                            <div id="myRateModal{{$course->id}}" class="modal hide">
                                <div class="modal-header">
                                    <button data-dismiss="modal" class="close" type="button">×</button>
                                    <h3>{{$course->title}}</h3>
                                </div>
                                <div class="modal-body"> 
                                    @foreach ($course->AcceptedStudents as $request)
                                        <div style="border-bottom: 1px solid #000; padding-bottom: 2px; margin-top: 2px"> 
                                            <div style="min-width: 200px; display:inline-block">
                                                Name: <a href="{{route('users.show',$request->student_id)}}">{{$request->student->full_name()}}</a>
                                            </div>
                                            <div style="min-width: 200px; display:inline-block">
                                                Rate: {{$request->rate}}
                                            </div>
                                            <div style="min-width: 200px; display:inline-block">
                                                Progress: {{$request->content->title}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!--Pop Up Model for View User Details-->
                        @endforeach
                    </tbody>
                </table>
                {{$courses->links()}}
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
                window.location.href="{{route('management')}}/"+deleteFunction+"/"+id;
            });
        });
    </script>
    
@endsection