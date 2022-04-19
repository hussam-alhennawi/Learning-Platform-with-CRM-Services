@extends('backEnd.layouts.master')
@section('title','Edit Advertisement')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('advertisements.index')}}">Advertisements</a> <a href="#" class="current">Edit Advertisement</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Edit Advertisement</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{route('advertisements.update',$advertisement->id)}}" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{method_field("PUT")}}
                            <div class="control-group{{$errors->has('title')?' has-error':''}}">
                                <label class="control-label">Advertisement Tilte :</label>
                                <div class="controls">
                                    <input type="text" name="title" id="title" value="{{$advertisement->title}}" required>
                                    <span class="text-danger" style="color: red;">{{$errors->first('title')}}</span>
                                </div>
                            </div>                         
                            <div class="control-group{{$errors->has('description')?' has-error':''}}">
                                <label class="control-label">Advertisement Description :</label>
                                <div class="controls">
                                    <textarea name="description" id="description" required>{{$advertisement->description}}</textarea>
                                    <span class="text-danger" style="color: red;">{{$errors->first('description')}}</span>
                                </div>
                            </div>                         
                            <div class="control-group">
                                <label class="control-label">Image upload</label>
                                <div class="controls">
                                    @if($advertisement->image === 'null')
                                        <input type="file" name="image" accept=".jpg, .jpeg, .png,"  id="image"/>
                                    @else
                                        <input type="hidden" name="countOldMedia" value="{{($advertisement->image === 'null')?0:1}}"/>
                                        <span class="text-danger">{{$errors->first('image')}}</span>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:" rel="{{$advertisement->id}}" rel1="delete-ads-image" class="btn btn-danger btn-mini deleteRecord">Delete Old Image</a>
                                        <img src="{{url('/photos/ads')}}/{{$advertisement->image}}" width="50" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">For Collages :</label>
                                <div class="controls" style="width: 245px;">
                                    @foreach($collages as $collage)
                                        <input name="collages[]" type="checkbox" value="{{$collage->id}}"
                                        @foreach($advertisement->collages as $coll)
                                            @if($collage->id == $coll->id)
                                                checked
                                            @endif
                                        @endforeach
                                            >{{$collage->name_en}}<br>
                                    @endforeach
                                </div>
                            </div> 
                            <div class="control-group">
                                <label class="control-label">For Classes :</label>
                                <div class="controls" style="width: 245px;">
                                    @foreach($classes as $class)
                                        <input name="classes[]" type="checkbox" value="{{$class->id}}"
                                        @foreach($advertisement->classes as $cla)
                                            @if($class->id == $cla->id)
                                                checked
                                            @endif
                                        @endforeach
                                            >{{$class->study_year}}: {{$class->subject->name_en}}-{{$class->type}}, by: {{$class->lecturer->first_name}}<br>
                                    @endforeach
                                </div>
                            </div> 
                            <div class="control-group">
                                <label for="control-label"></label>
                                <div class="controls">
                                    <input type="submit" value="Update" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsblock')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.custom.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.uniform.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/matrix.js') }}"></script>
    <script src="{{ asset('js/matrix.form_validation.js') }}"></script>
    <script src="{{ asset('js/matrix.tables.js') }}"></script>
    <script src="{{ asset('js/matrix.popover.js') }}"></script>
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