@extends('backEnd.layouts.master')
@section('title','List Library Projects')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('lib_projects.index')}}" class="current">Library Projects</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List Library Projects</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Arabic Title</th>
                        <th>English Title</th>
                        <th>Study Year</th>
                        <th>Subject</th>
                        <th>Students</th>
                        <th>SuperVisors</th>
                        <th>PDF File</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($lib_projects as $lib_project)
                            
                            <tr class="gradeC">
                                <td>{{$lib_project->title_ar}}</td>
                                <td>{{$lib_project->title_en}}</td>
                                <td>{{$lib_project->study_year}}</td>
                                <td>{{$lib_project->subject->collage->name_en}} : {{$lib_project->subject->name_en}}</td>
                                <td>
                                    @forelse ($lib_project->students as $student)
                                        <a href="{{route('users.show',$student->id)}}">{{$student->full_name()}}</a>
                                        @if (!$loop->last)
                                            ,<br>
                                        @endif
                                    @empty
                                        No Students
                                    @endforelse
                                </td>
                                <td>
                                    @forelse ($lib_project->supervisors as $supervisor)
                                        <a href="{{route('users.show',$supervisor->id)}}">{{$supervisor->full_name()}}</a>
                                        @if (!$loop->last)
                                            ,<br>
                                        @endif
                                    @empty
                                        No Supervisors
                                    @endforelse
                                </td>
                                <td>
                                    @if($lib_project->pdf_file)
                                    <a href="{{Storage::url('PDFfiles/'.$lib_project->pdf_file)}}" target="_blank" class="btn btn-success btn-mini">
                                        Download
                                    </a>
                                    @else
                                        No file
                                    @endif
                                </td>
                                <td style="text-align: left;">
                                    <a href="{{route('lib_projects.edit',$lib_project->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                    <a href="javascript:" rel="{{$lib_project->id}}" rel1="delete-lib" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$lib_projects->links()}}
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