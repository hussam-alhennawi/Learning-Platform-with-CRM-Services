@extends('backEnd.layouts.master')
@section('title','List Contents')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('contents.index')}}" class="current">Contents</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List Contents</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Course : Topic</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Sequence</th>
                        <th>Appendix</th>
                        <th>Video</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($contents as $content)
                            
                            <tr class="gradeC">
                                <td>{{$content->topic->course->title}} : {{$content->topic->name}}</td>
                                <td>{{$content->title}}</td>
                                <td>{{$content->description}}</td>
                                <td>{{$content->sequence}}</td>
                                <td>
                                    @if($content->appendix)
                                    <a href="{{Storage::url('ContentsAppendixFiles/'.$content->appendix)}}" target="_blank" class="btn btn-success btn-mini">
                                        Download
                                    </a>
                                    @else
                                        No file
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    <a href="#myModal{{$content->id}}" data-toggle="modal" class="btn btn-info btn-mini">View</a>
                                </td>
                                <td style="text-align: center;">
                                    <a href="{{route('contents.edit',$content->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                    <a href="javascript:" rel="{{$content->id}}" rel1="delete-cont" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                </td>
                            </tr>
                            {{--Pop Up Model for View User--}}
                            <div id="myModal{{$content->id}}" class="modal hide">
                                <div class="modal-header">
                                    <button data-dismiss="modal" class="close" type="button">×</button>
                                    <h3>{{$content->title}}</h3>
                                </div>
                                <div class="modal-body">
                                    @if($content->video_file)
                                        <div class="text-center" style="margin:5px;">
                                            <video width="300" height="" controls>
                                                <source src="{{Storage::url('ContentsVideos/'.$content->video_file)}}" type="video/mp4">
                                            </video>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{--Pop Up Model for View User Details--}}
                        @endforeach
                    </tbody>
                </table>
                {{$contents->links()}}
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