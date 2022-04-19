@extends('backEnd.layouts.master')
@section('title','List Advertisements')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('advertisements.index')}}" class="current">Advertisements</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List Advertisements</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>For Collages</th>
                        <th>For Classes</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($advertisements as $advertisement)
                            
                            <tr class="gradeC">
                                <td>{{$advertisement->title}}</td>
                                <td>{{$advertisement->description}}</td>
                                <td> 
                                    @if($advertisement->image)
                                    <div class="text-center" style="margin:5px;">
                                        <img src="{{url('/photos/ads')}}/{{$advertisement->image}}" width="50" alt="ads image">
                                    </div>
                                    @else
                                        No Image
                                    @endif
                                </td>
                                <td>
                                    @forelse ($advertisement->collages as $collage)
                                        {{$collage->name_en}}
                                        @if (!$loop->last)
                                            ,<br>
                                        @endif
                                    @empty
                                        Not For Collages
                                    @endforelse
                                </td>
                                <td>
                                    @forelse ($advertisement->classes as $class)
                                    {{$class->study_year}}: {{$class->subject->name_en}}-{{$class->type}}, by: {{$class->lecturer->full_name()}}
                                        @if (!$loop->last)
                                            ,<br>
                                        @endif
                                    @empty
                                        Not For Classes
                                    @endforelse
                                </td>
                                <td style="text-align: left;">
                                    <a href="{{route('advertisements.edit',$advertisement->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                    <a href="javascript:" rel="{{$advertisement->id}}" rel1="delete-adv" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$advertisements->links()}}
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