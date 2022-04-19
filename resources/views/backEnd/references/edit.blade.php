@extends('backEnd.layouts.master')
@section('title','Edit Reference')
@section('content')
    <div id="breadcrumb"> <a href="{{route('management')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="{{route('references.index')}}">References</a> <a href="#" class="current">Edit Reference</a> </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Edit Reference</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{route('references.update',$reference->id)}}" name="basic_validate" id="basic_validate" novalidate="novalidate" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            {{method_field("PUT")}}
                                                       
                        <div class="control-group{{$errors->has('title')?' has-error':''}}">
                            <label class="control-label">Reference Tilte :</label>
                            <div class="controls">
                                <input type="text" name="title" id="title" value="{{$reference->title}}" required>
                                <span class="text-danger" id="title" style="color: red;">{{$errors->first('title')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('author')?' has-error':''}}">
                            <label class="control-label">Author :</label>
                            <div class="controls">
                                <input type="text" name="author" id="author" value="{{$reference->author}}" required>
                                <span class="text-danger" id="author" style="color: red;">{{$errors->first('author')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('publisher')?' has-error':''}}">
                            <label class="control-label">Publisher :</label>
                            <div class="controls">
                                <input type="text" name="publisher" id="publisher" value="{{$reference->publisher}}" required>
                                <span class="text-danger" id="publisher" style="color: red;">{{$errors->first('publisher')}}</span>
                            </div>
                        </div>
                        <div class="control-group{{$errors->has('publish_year')?' has-error':''}}">
                            <label class="control-label">Publish Year :</label>
                            <div class="controls">
                                <input type="number" max="{{date('Y')}}" name="publish_year" id="publish_year" value="{{$reference->publish_year}}" required>
                                <span class="text-danger" id="publish_year" style="color: red;">{{$errors->first('publish_year')}}</span>
                            </div>
                        </div>                         
                        <div class="control-group{{$errors->has('category')?' has-error':''}}">
                            <label class="control-label">Category :</label>
                            <div class="controls">
                                <input type="text" name="category" id="category" value="{{$reference->category}}" required>
                                <span class="text-danger" id="category" style="color: red;">{{$errors->first('category')}}</span>
                            </div>
                        </div>                                    
                        <div class="control-group{{$errors->has('description')?' has-error':''}}">
                            <label class="control-label">Description :</label>
                            <div class="controls">
                                <textarea name="description" id="description" required>{{$reference->description}}</textarea>
                                <span class="text-danger" style="color: red;">{{$errors->first('description')}}</span>
                            </div>
                        </div>                   
                        <div class="control-group">
                            <label class="control-label">PDF file</label>
                            <div class="controls">
                                @if($reference->pdf_file === 'null')
                                    <input type="file" name="pdf_file" accept=".pdf"  id="pdf_file" required/>
                                @else
                                    <input type="hidden" name="countOldPDF" value="{{($reference->pdf_file === 'null')?0:1}}"/>
                                    <span class="text-danger">{{$errors->first('pdf_file')}}</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="javascript:" rel="{{$reference->id}}" rel1="delete-ref-pdf" class="btn btn-danger btn-mini deleteRecord">Delete Old file</a>
                                    <a href="{{Storage::url('PDFfiles/'.$reference->pdf_file)}}" target="_blank" class="btn btn-primary btn-mini">Download</a>
                                @endif
                            </div>
                        </div>                  
                        <div class="control-group">
                            <label class="control-label">Image upload</label>
                            <div class="controls">
                                @if($reference->image === 'null')
                                    <input type="file" name="image" accept=".jpg, .jpeg, .png,"  id="image"/>
                                @else
                                    <input type="hidden" name="countOldMedia" value="{{($reference->image === 'null')?0:1}}"/>
                                    <span class="text-danger">{{$errors->first('image')}}</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="javascript:" rel="{{$reference->id}}" rel1="delete-reference-img" class="btn btn-danger btn-mini deleteRecord">Delete Old Image</a>
                                    <img src="{{url('/photos/references')}}/{{$reference->image}}" width="50" alt="">
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