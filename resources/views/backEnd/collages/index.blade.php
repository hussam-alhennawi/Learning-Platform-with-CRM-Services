@extends('backEnd.layouts.master')
@section('title','List Collages')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('collages.index')}}" class="current">Collages</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List Collages</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Collage Image</th>
                        <th>Collage Arabic Name</th>
                        <th>Collage English Name</th>
                        <th>Description</th>
                        <th>Number of Lecturers</th>
                        <th>Number of Students</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($collages as $collage)
                            
                            <tr class="gradeC">
                                <td> 
                                    @if($collage->image)
                                    <div class="text-center" style="margin:5px;">
                                        <img src="{{url('/photos/collages')}}/{{$collage->image}}" width="50" alt="collage image">
                                    </div>
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{$collage->name_ar}}</td>
                                <td>{{$collage->name_en}}</td>
                                <td>{{$collage->description}}</td>
                                <td>
                                    <a href="#myLec{{$collage->id}}" data-toggle="modal" class="btn btn-info btn-mini">{{$collage->Lecturers()->count()}}</a>
                                </td>
                                <td>
                                    <a href="#myStu{{$collage->id}}" data-toggle="modal" class="btn btn-info btn-mini">{{$collage->Students()->count()}}</a>
                                </td>
                                    <td style="text-align: left;">
                                    <a href="{{route('getSubjectsByCol',$collage->id)}}" class="btn btn-success btn-mini">Subjects</a>
                                    <a href="{{route('collages.edit',$collage->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                    <a href="javascript:" rel="{{$collage->id}}" rel1="delete-col" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                </td>
                            </tr>
                            <!--Pop Up Model for View Lecturers-->
                            <div id="myLec{{$collage->id}}" class="modal hide">
                                <div class="modal-header">
                                    <button data-dismiss="modal" class="close" type="button">×</button>
                                    <h3>{{$collage->name_en}}</h3>
                                    <h4>{{$collage->Lecturers()->count()}} Lecturer</h4>
                                </div>
                                <div class="modal-body">
                                    @foreach ($collage->Lecturers as $lec)
                                        <p class="text-center">{{$lec->lecturer_id}} :<a href="{{route('users.show',$lec->lecturer_id)}}">{{$lec->lecturer->full_name()}}</a></p>
                                    @endforeach
                                </div>
                            </div>
                            <!--Pop Up Model for View Lecturers Details-->
                            <!--Pop Up Model for View Students-->
                            <div id="myStu{{$collage->id}}" class="modal hide">
                                <div class="modal-header">
                                    <button data-dismiss="modal" class="close" type="button">×</button>
                                    <h3>{{$collage->name_en}}</h3>
                                    <h4>{{$collage->Students()->count()}} Student</h4>
                                </div>
                                <div class="modal-body">
                                    @foreach ($collage->Students as $stu)
                                        <p class="text-center">{{$stu->student_id}} :<a href="{{route('users.show',$stu->student_id)}}">{{$stu->student->full_name()}}</a></p>
                                    @endforeach
                                </div>
                            </div>
                            <!--Pop Up Model for View Lecturers Details-->
                        @endforeach
                    </tbody>
                </table>
                {{$collages->links()}}
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