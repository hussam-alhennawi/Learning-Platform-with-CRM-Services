@extends('backEnd.layouts.master')
@section('title','List Lectures')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('lectures.index')}}" class="current">Lectures</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List Lectures</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Class</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>PDF File</th>
                        <th>QR-Code</th>
                        {{-- <th>Checks In</th> --}}
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($lectures as $lecture)
                            
                            <tr class="gradeC">
                                <td>{{$lecture->_class->subject->collage->name_en}}: {{$lecture->_class->study_year}}: {{$lecture->_class->subject->name_en}}-{{$lecture->_class->type}}, by: <a href="{{route('users.show',$lecture->_class->lecturer_id)}}">{{$lecture->_class->lecturer->full_name()}}</a></td>
                                <td>{{$lecture->title}}</td>
                                <td>{{$lecture->date}}</td>
                                <td>
                                    @if($lecture->pdf_file)
                                    <a href="{{Storage::url('PDFfiles/'.$lecture->pdf_file)}}" target="_blank" class="btn btn-success btn-mini">
                                        Download
                                    </a>
                                    @else
                                        No file
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center" style="margin:5px;">
                                        <img src="{{Storage::url('QR-codes/'.$lecture->qr_code)}}" width="50" alt="collage image">
                                    </div>
                                </td>
                                {{-- <td>
                                    <a href="#myModal{{$lecture->id}}" data-toggle="modal" class="btn btn-info btn-mini">{{$lecture->checksIn()->count()}}</a>
                                </td> --}}
                                <td style="text-align: left;">
                                    <a href="{{route('lectures.edit',$lecture->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                    <a href="javascript:" rel="{{$lecture->id}}" rel1="delete-lec" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                </td>
                            </tr>
                            <!--Pop Up Model for View Students-->
                            <div id="myModal{{$lecture->id}}" class="modal hide">
                                <div class="modal-header">
                                    <button data-dismiss="modal" class="close" type="button">×</button>
                                    <h3>{{$lecture->title}}</h3>
                                    <h4>{{$lecture->checksIn()->count()}} Students Checked In</h4>
                                </div>
                                <div class="modal-body">
                                    @foreach ($lecture->checksIn as $ch)
                                        <p class="text-center">{{$ch->student_class->student_id}} :<a href="{{route('users.show',$ch->student_class->student_id)}}">{{$ch->student_class->student->full_name()}}</a></p>
                                    @endforeach
                                </div>
                            </div>
                            <!--Pop Up Model for View Students Details-->
                        @endforeach
                    </tbody>
                </table>
                {{$lectures->links()}}
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