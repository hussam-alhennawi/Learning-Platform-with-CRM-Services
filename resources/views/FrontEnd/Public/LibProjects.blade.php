@extends('FrontEnd.Public.master')
@section('title','Projects')
@section('content')
    @include('FrontEnd.Public.white-navbar')
        <!-- Shop Page 1 Area Start Here -->
        <div class="shop-page1-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 col-md-push-3">
                        {{$libProjects->appends(request()->input())->links()}}
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="courses-page-top-area">
                                    <div class="courses-page-top-left">
                                        <p>Showing {{$libProjects->firstItem()}}-{{$libProjects->lastItem()}} of {{$libProjects->total()}} results</p>
                                    </div>
                                    <div class="courses-page-top-right">
                                        <ul>
                                            <li class="active"><a href="#list-view" data-toggle="tab" aria-expanded="true"><i class="fa fa-list"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- Listed product show -->
                                <div role="tabpanel" class="tab-pane active" id="list-view">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        @foreach($libProjects as $lib)
                                        <div class="product-box2">
                                            <div class="media">
                                                <div class="media-body">
                                                    <div class="product-box2-content">
                                                        <h3><a href="{{route('project',$lib->id)}}">{{$lib->title_en}}</a></h3>
                                                        <span>{{$lib->subject->name_en}}</span>
                                                        <p> By Students: (
                                                            @forelse ($lib->students as $student)
                                                                {{$student->full_name()}}
                                                                @if (!$loop->last)
                                                                    ,
                                                                @endif
                                                            @empty
                                                                No Students
                                                            @endforelse
                                                            ) 
                                                            Supervisors: (
                                                            @forelse ($lib->supervisors as $supervisor)
                                                                <a href="{{route('user',$supervisor->id)}}">{{$supervisor->full_name()}}</a>
                                                                @if (!$loop->last)
                                                                    ,
                                                                @endif
                                                            @empty
                                                                No Supervisors
                                                            @endforelse
                                                            )
                                                        </p>
                                                    </div>
                                                    <ul class="product-box2-cart">
                                                        @if($user && $user->hasRole('Internal_student'))
                                                            <?php $fav = false; ?>
                                                            @foreach ($user->FavouriteLibProjects as $favLib)
                                                                @if($favLib->lib_project_id == $lib->id)
                                                                    <?php $fav = true; ?>
                                                                    @break
                                                                @endif
                                                            @endforeach
                                                            <li style="{{(!$fav)?'display: none':''}}"><a class="rmv-fav" data-item-id="{{$lib->id}}" data-url="{{route('rmv-proj-from-fav')}}" title="Remove From Favourite List"><i aria-hidden="true" class="fa fa-heart"></i></a></li>
                                                            <li style="{{($fav)?'display: none':''}}"><a class="add-fav" data-item-id="{{$lib->id}}" data-url="{{route('add-proj-to-fav')}}" title="Add To Favourite List"><i aria-hidden="true" class="fa fa-heart-o"></i></a></li>
                                                        @endif
                                                        <li><a href="{{Storage::url('PDFfiles/'.$lib->pdf_file)}}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 col-md-pull-9">
                        <div class="sidebar">
                            <div class="sidebar-box">
                                <div class="sidebar-box-inner">
                                    <h3 class="sidebar-title">Search</h3>
                                    <div class="sidebar-find-course">
                                        <form id="checkout-form" method="GET" action="{{route('libProjects')}}">
                                            <div class="form-group course-name">
                                                <input id="first-name" placeholder="Project Name" name="title" value="{{request()->input('title')}}" class="form-control" type="text" />
                                            </div>
                                            <div class="form-group">
                                                <button class="sidebar-search-btn disabled" type="submit" value="Login">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="sidebar-box">
                                <div class="sidebar-box-inner">
                                    <h3 class="sidebar-title">My Projects</h3>
                                    <div class="sidebar-best-seller-area">
                                        <ul>
                                            @foreach($myLibProjects as $mlib)
                                            <li>
                                                <div class="related-content">
                                                    <h4><a href="{{route('project',$mlib->id)}}">{{$mlib->title_en}}</a></h4>
                                                    <p>{{$mlib->subject->name_en}}</p>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shop Page 1 Area End Here -->
        
@endsection
@section('Extra-JS')
<script>
    $('.pagination').addClass('pagination-center');   
    $('.pagination-center').removeClass('pagination');   
    $('.pagination-center').find('.active').each(function(){
        var activeText = $(this).html();
        $(this).html('<a class="page-link">'+activeText+'</a>');
    });   
    $('.pagination-center').find('.disabled').each(function(){
        var disabledText = $(this).html();
        $(this).html('<a class="page-link">'+disabledText+'</a>');
    });   
</script>  

<script>
    $('.add-fav').hover(function(){
        $(this).find('i').addClass('fa-heart');
        $(this).find('i').removeClass('fa-heart-o');
        $(this).css('cursor', 'pointer');
    },
    function(){
        $(this).find('i').addClass('fa-heart-o');
        $(this).find('i').removeClass('fa-heart');
        $(this).css('cursor', 'default');
    });
</script>

<script>
    $('.rmv-fav').hover(function(){
        $(this).find('i').removeClass('fa-heart');
        $(this).find('i').addClass('fa-heart-o');
        $(this).css('cursor', 'pointer');
    },
    function(){
        $(this).find('i').removeClass('fa-heart-o');
        $(this).find('i').addClass('fa-heart');
        $(this).css('cursor', 'default');
    });
</script>


<script>
    $('.add-fav').click(function(){
        var url = $(this).attr('data-url');
        var item = $(this).attr('data-item-id');
        var li = $(this);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method:"POST",
            url:url,
            dataType:"json",
            data:{
                _token: CSRF_TOKEN,
                item: item
            },
            success: function(response){
                console.log(response);
                $('.add-fav').parent().attr('style','display:none;');
                $('.rmv-fav').parent().removeAttr('style');
            },
            error: function(e){
                alert(e.responseText);
            }
        });
    });
</script>

<script>
    $('.rmv-fav').click(function(){
        var url = $(this).attr('data-url');
        var item = $(this).attr('data-item-id');
        var li = $(this);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method:"POST",
            url:url,
            dataType:"json",
            data:{
                _token: CSRF_TOKEN,
                item: item
            },
            success: function(response){
                $('.add-fav').parent().removeAttr('style');
                $('.rmv-fav').parent().attr('style','display:none;');
            },
            error: function(e){
                alert(e.responseText);
            }
        });
    });
</script>
@endsection