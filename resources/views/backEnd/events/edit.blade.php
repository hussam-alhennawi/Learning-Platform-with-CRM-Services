@extends('backEnd.layouts.master')
@section('title','Edit Event')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('events.index')}}">Events</a> <a href="#" class="current">Edit Event</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Edit Event</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{route('events.update',$event->id)}}" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{method_field("PUT")}}
                            <div class="control-group{{$errors->has('name')?' has-error':''}}">
                                <label class="control-label">Event Name :</label>
                                <div class="controls">
                                    <input type="text" name="name" id="name" value="{{$event->name}}" required>
                                    <span class="text-danger" style="color: red;">{{$errors->first('name')}}</span>
                                </div>
                            </div>                            
                            <div class="control-group{{$errors->has('started_at')?' has-error':''}}">
                                <label class="control-label">Event Start Date :</label>
                                <div class="controls">
                                    <input type="datetime-local" name="started_at" id="started_at" value="{{str_replace(' ','T',$event->started_at)}}" required>
                                    <span class="text-danger" style="color: red;">{{$errors->first('started_at')}}</span>
                                </div>
                            </div>                            
                            <div class="control-group{{$errors->has('ended_at')?' has-error':''}}">
                                <label class="control-label">Event End Date :</label>
                                <div class="controls">
                                    <input type="datetime-local" name="ended_at" id="ended_at" value="{{str_replace(' ','T',$event->ended_at)}}" required>
                                    <span class="text-danger" style="color: red;">{{$errors->first('ended_at')}}</span>
                                </div>
                            </div>                            
                            <div class="control-group{{$errors->has('location')?' has-error':''}}">
                                <label class="control-label">Event End Date :</label>
                                <div class="controls">
                                    <input type="text" name="location" id="location" value="{{$event->location}}" required>
                                    <span class="text-danger" style="color: red;">{{$errors->first('location')}}</span>
                                </div>
                            </div>                            
                            <div class="control-group{{$errors->has('description')?' has-error':''}}">
                                <label class="control-label">Event Description :</label>
                                <div class="controls">
                                    <textarea name="description" id="description" required>{{$event->description}}</textarea>
                                    <span class="text-danger" style="color: red;">{{$errors->first('description')}}</span>
                                </div>
                            </div>                            
                            <div class="control-group">
                                <label class="control-label">Image upload</label>
                                <div class="controls">
                                    @if($event->image === 'null')
                                        <input type="file" name="image" accept=".jpg, .jpeg, .png,"  id="image"/>
                                    @else
                                        <input type="hidden" name="countOldMedia" value="{{($event->image === 'null')?0:1}}"/>
                                        <span class="text-danger">{{$errors->first('image')}}</span>
                                        &nbsp;&nbsp;&nbsp;
                                        <a href="javascript:" rel="{{$event->id}}" rel1="delete-event-img" class="btn btn-danger btn-mini deleteRecord">Delete Old Image</a>
                                        <img src="{{url('/photos/events')}}/{{$event->image}}" width="50" alt="">
                                    @endif
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
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
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