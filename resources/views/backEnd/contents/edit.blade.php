@extends('backEnd.layouts.master')
@section('title','Edit Content')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('contents.index')}}">Contents</a> <a href="#" class="current">Edit Content</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Edit Content</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{route('contents.update',$content->id)}}" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{method_field("PUT")}}
                            
                            <div class="control-group{{$errors->has('topic_id')?' has-error':''}}">
                                <label class="control-label">Select Topic :</label>
                                <div class="controls">
                                    <select name="topic_id" style="width: 415px;">
                                        @foreach ($topics as $topic)
                                            <option value="{{$topic->id}}" {{($content->topic_id == $topic->id)?'selected':''}}>{{$topic->course->title}} : {{$topic->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="topic_id" style="color: red;">{{$errors->first('topic_id')}}</span>
                                </div>
                            </div>                            
                        <div class="control-group{{$errors->has('title')?' has-error':''}}">
                            <label class="control-label">Tilte :</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" value="{{$content->title}}" required>
                                <span class="text-danger" id="title" style="color: red;">{{$errors->first('title')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('description')?' has-error':''}}">
                            <label class="control-label">Description :</label>
                            <div class="controls">
                                <textarea name="description" id="description" required>{{$content->description}}</textarea>
                                <span class="text-danger" id="description" style="color: red;">{{$errors->first('description')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('sequence')?' has-error':''}}">
                            <label class="control-label">Sequence :</label>
                            <div class="controls">
                                <input type="number" name="sequence" id="sequence" value="{{$content->sequence}}" required>
                                <span class="text-danger" id="sequence" style="color: red;">{{$errors->first('sequence')}}</span>
                            </div>
                        </div>                            
                        <div class="control-group">
                            <label class="control-label">Appendix</label>
                            <div class="controls">
                                @if(!$content->appendix)
                                    <input type="file" name="appendix"  id="appendix"/>
                                @else
                                    <span class="text-danger">{{$errors->first('appendix')}}</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="javascript:" rel="{{$content->id}}" rel1="delete-cont-appendix" class="btn btn-danger btn-mini deleteRecord">Delete Old file</a>
                                    <a href="{{Storage::url('ContentsAppendixFiles/'.$content->appendix)}}" target="_blank" class="btn btn-primary btn-mini">Download</a>
                                @endif
                            </div>
                        </div>               
                        <div class="control-group">
                            <label class="control-label">Video</label>
                            <div class="controls">
                                @if($content->video_file === 'null')
                                    <input type="file" name="video_file" accept=".mp4"  id="video_file"/>
                                @else
                                    <input type="hidden" name="countOldVideo" value="{{($content->video_file === 'null')?0:1}}"/>
                                    <span class="text-danger">{{$errors->first('video_file')}}</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="javascript:" rel="{{$content->id}}" rel1="delete-cont-vid" class="btn btn-danger btn-mini deleteRecord">Delete Old Video</a>
                                    
                                    <div class="text-center" style="margin:5px;">
                                        <video width="300" height="" controls>
                                            <source src="{{Storage::url('ContentsVideos/'.$content->video_file)}}" type="video/mp4">
                                        </video>
                                    </div>

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