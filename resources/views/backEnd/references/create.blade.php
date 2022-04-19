@extends('backEnd.layouts.master')
@section('title','Add Reference')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('references.index')}}">References</a> <a href="{{route('references.create')}}" class="current">Add New Reference</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                    <h5>Add New Reference</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{route('references.store')}}" name="basic_validate" id="add_userpassword_validate" novalidate="novalidate" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="control-group{{$errors->has('title')?' has-error':''}}">
                            <label class="control-label">Reference Title :</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" value="{{old('title')}}" required>
                                <span class="text-danger" id="title" style="color: red;">{{$errors->first('title')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('author')?' has-error':''}}">
                            <label class="control-label">Author :</label>
                            <div class="controls">
                                <input type="text" name="author" id="author" value="{{old('author')}}" required>
                                <span class="text-danger" id="author" style="color: red;">{{$errors->first('author')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('publisher')?' has-error':''}}">
                            <label class="control-label">Publisher :</label>
                            <div class="controls">
                                <input type="text" name="publisher" id="publisher" value="{{old('publisher')}}" required>
                                <span class="text-danger" id="publisher" style="color: red;">{{$errors->first('publisher')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('publish_year')?' has-error':''}}">
                            <label class="control-label">Publish year :</label>
                            <div class="controls">
                                <input type="number" max="{{date('Y')}}" name="publish_year" id="publish_year" value="{{old('publish_year')}}" required>
                                <span class="text-danger" id="publish_year" style="color: red;">{{$errors->first('publish_year')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('category')?' has-error':''}}">
                            <label class="control-label">Category :</label>
                            <div class="controls">
                                <input type="text" name="category" id="category" value="{{old('category')}}" required>
                                <span class="text-danger" id="category" style="color: red;">{{$errors->first('category')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('description')?' has-error':''}}">
                            <label class="control-label">Description :</label>
                            <div class="controls">
                                <textarea name="description" id="description" value="{{old('description')}}" required></textarea>
                                <span class="text-danger" id="description" style="color: red;">{{$errors->first('description')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('pdf_file')?' has-error':''}}">
                            <label class="control-label">PDF file :</label>
                            <div class="controls">
                                <input type="file" name="pdf_file" id="pdf_file" value="{{old('pdf_file')}}" accept=".pdf" required>
                                <span class="text-danger" id="pdf_file" style="color: red;">{{$errors->first('pdf_file')}}</span>
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