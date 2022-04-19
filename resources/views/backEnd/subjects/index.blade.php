@extends('backEnd.layouts.master')
@section('title','List Subjects')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('subjects.index')}}" class="current">Subjects</a></div>
    <div class="container-fluid">
        @if(Session::has('message'))
            <div class="alert alert-success text-center" role="alert">
                <strong>Well done!</strong> {{Session::get('message')}}
            </div>
        @endif
        <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                <h5>List Subjects</h5>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered data-table">
                    <thead>
                    <tr>
                        <th>Collage</th>
                        <th>Subject Arabic Name</th>
                        <th>Subject English Name</th>
                        <th>Classes</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($subjects as $subject)
                            
                            <tr class="gradeC">
                                <td>{{$subject->collage->name_en}}</td>
                                <td>{{$subject->name_ar}}</td>
                                <td>{{$subject->name_en}}</td>
                                <td>
                                    @if($subject->classes()->count())
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Years
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <?php $subjects2 = [] ?>
                                            @foreach($subject->classes as $cla)
                                                @if(!array_key_exists($subject->id.'/'.$cla->study_year,$subjects2))
                                                    <?php $subjects2[$subject->id.'/'.$cla->study_year]['year'] = $cla->study_year?>
                                                    <?php $subjects2[$subject->id.'/'.$cla->study_year]['count'] = 1?>
                                                @else
                                                    <?php $subjects2[$subject->id.'/'.$cla->study_year]['count'] += 1?>
                                                @endif
                                            @endforeach
                                            @foreach($subjects2 as $k=>$v)
                                                <li class="get-classes"><a href="{{url('management/get-classes-by-sub/'.$k)}}">[{{$v['year']}}] ({{$v['count']}}) Classes</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @else
                                        No Available Classes
                                    @endif
                                </td>
                                    <td style="text-align: left;">
                                    <a href="{{route('subjects.edit',$subject->id)}}" class="btn btn-primary btn-mini">Edit</a>
                                    <a href="javascript:" rel="{{$subject->id}}" rel1="delete-sub" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$subjects->links()}}
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