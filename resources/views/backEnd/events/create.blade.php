@extends('backEnd.layouts.master')
@section('title','Add Event')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('events.index')}}">Events</a> <a href="{{route('events.create')}}" class="current">Add New Event</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>Add New Event</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{route('events.store')}}" name="basic_validate" id="add_userpassword_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="control-group{{$errors->has('name')?' has-error':''}}">
                            <label class="control-label">Name :</label>
                            <div class="controls">
                                <input type="text" name="name" id="name" value="{{old('name')}}" required>
                                <span class="text-danger" id="name" style="color: red;">{{$errors->first('name')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('started_at')?' has-error':''}}">
                            <label class="control-label">Started at :</label>
                            <div class="controls">
                                <input type="datetime-local" name="started_at" id="started_at" value="{{old('started_at')}}" required>
                                <span class="text-danger" id="started_at" style="color: red;">{{$errors->first('started_at')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('ended_at')?' has-error':''}}">
                            <label class="control-label">Ended at :</label>
                            <div class="controls">
                                <input type="datetime-local" name="ended_at" id="ended_at" value="{{old('ended_at')}}" required>
                                <span class="text-danger" id="ended_at" style="color: red;">{{$errors->first('ended_at')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('location')?' has-error':''}}">
                            <label class="control-label">Location :</label>
                            <div class="controls">
                                <input type="text" name="location" id="location" value="{{old('location')}}" required>
                                <span class="text-danger" id="location" style="color: red;">{{$errors->first('location')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('description')?' has-error':''}}">
                            <label class="control-label">Description :</label>
                            <div class="controls">
                                <textarea name="description" id="description" value="{{old('description')}}" required></textarea>
                                <span class="text-danger" id="description" style="color: red;">{{$errors->first('description')}}</span>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Image</label>
                            <div class="controls">
                                <input type="file" name="image" accept=".jpg, .jpeg, .png" id="image"/>
                                <span class="text-danger">{{$errors->first('image')}}</span>
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