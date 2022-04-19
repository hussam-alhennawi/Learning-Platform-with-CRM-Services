@extends('backEnd.layouts.master')
@section('title','List Requests')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('courses.requests')}}" class="current">Requests</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List Requests</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Course</th>
                        <th>Student</th>
                        <th>Payment Check</th>
                        <th>Status</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $request)
                            
                            <tr class="gradeC">
                                <td>{{$request->date}}</td>
                                <td><a href="{{route('courses.show',$request->course_id)}}">{{$request->course->title}}</a></td>
                                <td><a href="{{route('users.show',$request->student_id)}}">{{$request->student->full_name()}}</a></td>
                                <td>
                                    @if($request->payment_check)
                                    <a href="{{Storage::url('PDFfiles/'.$request->payment_check)}}" target="_blank" class="btn btn-success btn-mini">
                                        Download
                                    </a>
                                    @else
                                        No file
                                    @endif
                                </td>
                                <td>{{$request->status}}</td>
                                <td>{{($request->active)?'Yes':'No'}}</td>
                                
                                <td style="text-align: left;">
                                    @if($request->status == "Pending")
                                        <a href="{{route('courses.acceptRequest',$request->id)}}" class="btn btn-success btn-mini">Accept</a>
                                    @endif
                                    @if(($request->status != "Blocked")&&$request->status != "Done")
                                        <a href="javascript:" rel="{{$request->id}}" rel1="{{route('courses.BlockRequest',$request->id)}}" class="btn btn-danger btn-mini BlockRecord">Block</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        $(".BlockRecord").click(function () {
            var id=$(this).attr('rel');
            var deleteFunction=$(this).attr('rel1');
            swal({
                title:'Are you sure?',
                text:"You won't be able to revert this!",
                type:'warning',
                showCancelButton:true,
                confirmButtonColor:'#3085d6',
                cancelButtonColor:'#d33',
                confirmButtonText:'Yes, block this!',
                cancelButtonText:'No, cancel!',
                confirmButtonClass:'btn btn-success',
                cancelButtonClass:'btn btn-danger',
                buttonsStyling:false,
                reverseButtons:true
            },function () {
                window.location.href=deleteFunction;
            });
        });
    </script>
    
@endsection