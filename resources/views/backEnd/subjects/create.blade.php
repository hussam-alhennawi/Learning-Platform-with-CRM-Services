@extends('backEnd.layouts.master')
@section('title','Add Subject')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('subjects.index')}}">Subjects</a> <a href="{{route('subjects.create')}}" class="current">Add New Subject</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>Add New Subject</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{route('subjects.store')}}" name="basic_validate" id="add_userpassword_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="control-group{{$errors->has('collage_id')?' has-error':''}}">
                            <label class="control-label">Select Collage :</label>
                            <div class="controls">
                                <select name="collage_id" style="width: 415px;">
                                    @foreach ($collages as $collage)
                                        <option value="{{$collage->id}}">{{$collage->name_en}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="collage_id" style="color: red;">{{$errors->first('collage_id')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('name_ar')?' has-error':''}}">
                            <label class="control-label">Arabic Name :</label>
                            <div class="controls">
                                <input type="text" name="name_ar" id="name_ar" value="{{old('name_ar')}}" required>
                                <span class="text-danger" id="name_ar" style="color: red;">{{$errors->first('name_ar')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('name_en')?' has-error':''}}">
                            <label class="control-label">English Name :</label>
                            <div class="controls">
                                <input type="text" name="name_en" id="name_en" value="{{old('name_en')}}" required>
                                <span class="text-danger" id="name_en" style="color: red;">{{$errors->first('name_en')}}</span>
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