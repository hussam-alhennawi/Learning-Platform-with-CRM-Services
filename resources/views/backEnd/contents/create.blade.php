@extends('backEnd.layouts.master')
@section('title','Add Content')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('contents.index')}}">Contents</a> <a href="{{route('contents.create')}}" class="current">Add New Content</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>Add New Content</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{route('contents.store')}}" name="basic_validate" id="add_userpassword_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="control-group{{$errors->has('topic_id')?' has-error':''}}">
                            <label class="control-label">Select Topic :</label>
                            <div class="controls">
                                <select name="topic_id" style="width: 415px;">
                                    @foreach ($topics as $topic)
                                <option value="{{$topic->id}}">{{$topic->course->title}} : {{$topic->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="topic_id" style="color: red;">{{$errors->first('topic_id')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('title')?' has-error':''}}">
                            <label class="control-label">Title :</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" value="{{old('title')}}" required>
                                <span class="text-danger" id="title" style="color: red;">{{$errors->first('title')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('description')?' has-error':''}}">
                            <label class="control-label">Description :</label>
                            <div class="controls">
                                <textarea name="description" id="description" value="{{old('description')}}" required></textarea>
                                <span class="text-danger" id="description" style="color: red;">{{$errors->first('description')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('sequence')?' has-error':''}}">
                            <label class="control-label">Sequence :</label>
                            <div class="controls">
                                <input type="number" name="sequence" id="sequence" value="{{old('sequence')}}" required>
                                <span class="text-danger" id="sequence" style="color: red;">{{$errors->first('sequence')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('appendix')?' has-error':''}}">
                            <label class="control-label">Appendix :</label>
                            <div class="controls">
                                <input type="file" name="appendix" id="appendix" value="{{old('appendix')}}">
                                <span class="text-danger" id="appendix" style="color: red;">{{$errors->first('appendix')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('video_file')?' has-error':''}}">
                            <label class="control-label">Video File :</label>
                            <div class="controls">
                                <input type="file" name="video_file" id="video_file" required value="{{old('video_file')}}" accept=".mp4">
                                <span class="text-danger" id="video_file" style="color: red;">{{$errors->first('video_file')}}</span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="control-label"></label>
                            <div class="controls">
                                <input type="submit" value="Add New" class="btn btn-success">
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
@endsection