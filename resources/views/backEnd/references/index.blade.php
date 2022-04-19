@extends('backEnd.layouts.master')
@section('title','List References')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('references.index')}}" class="current">References</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List References</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Reference Title</th>
                        <th>Image</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Publish Year</th>
                        <th>Category</th>
                        <th>Discription</th>
                        <th>PDF File</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($references as $reference)
                            
                            <tr class="gradeC">
                                <td>{{$reference->title}}</td>
                                <td> 
                                    @if($reference->image)
                                    <div class="text-center" style="margin:5px;">
                                        <img src="{{url('/photos/references')}}/{{$reference->image}}" width="50" alt="event image">
                                    </div>
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>{{$reference->author}}</td>
                                <td>{{$reference->publisher}}</td>
                                <td>{{$reference->publish_year}}</td>
                                <td>{{$reference->category}}</td>
                                <td>{{$reference->description}}</td>
                                <td>
                                    @if($reference->pdf_file)
                                    <a href="{{Storage::url('PDFfiles/'.$reference->pdf_file)}}" target="_blank" class="btn btn-success btn-mini">
                                        Download
                                    </a>
                                    @else
                                        No file
                                    @endif
                                </td>
                                <td style="text-align: left;">
                                    <a href="{{route('references.edit',$reference->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                    <a href="javascript:" rel="{{$reference->id}}" rel1="delete-ref" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$references->links()}}
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