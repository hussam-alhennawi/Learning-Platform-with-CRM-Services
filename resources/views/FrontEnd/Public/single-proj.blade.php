@extends('FrontEnd.Public.master')
@section('title',$project->title_en)
@section('content')
    @include('FrontEnd.Public.white-navbar')
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area" style="background-image: url('{{asset('img/banner/5.jpg')}}');">
            <div class="container">
                <div class="pagination-area">
                    <h1>{{$project->title}}</h1>
                    <ul>
                        <li><a href="{{route('/')}}">Home</a> -</li>
                        <li>Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Shop Page 1 Area Start Here -->
        <div class="shop-details-page-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 col-md-push-3">
                        <div class="inner-shop-details">
                            <div class="product-details-info-area">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="inner-product-details-right">
                                            <h3>{{$project->title_en}}</h3>
                                            <h5>({{$project->study_year}})</h5>
                                            {{-- <p class="price">{{$project->FavouriteLists()->count()}} Student Liked this</p> --}}
                                            <div class="product-details-content">
                                                <p><span>Suject:</span> {{$project->subject->name_en}}</p>
                                                <p><span>Students:</span> 
                                                    @forelse ($project->students as $student)
                                                        {{$student->full_name()}}
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @empty
                                                        No Students
                                                    @endforelse</p>
                                                <p><span>Supervisors:</span> 
                                                    @forelse ($project->supervisors as $supervisor)
                                                        <a href="{{route('user',$supervisor->id)}}">{{$supervisor->full_name()}}</a>
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @empty
                                                        No Supervisors
                                                    @endforelse</p>
                                            </div>
                                            <ul class="inner-product-details-cart">
                                                <li><a href="#">Like & Download <i class="fa fa-angle-double-right"></i></a></li>
                                                <li><a href="{{Storage::url('PDFfiles/'.$project->pdf_file)}}" target="_blank"><i aria-hidden="true" class="fa fa-download"></i></a></li>
                                                @if($user && $user->hasRole('Internal_student'))
                                                    <?php $fav = false; ?>
                                                    @foreach ($user->FavouriteLibProjects as $favLib)
                                                        @if($favLib->lib_project_id == $project->id)
                                                            <?php $fav = true; ?>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    <li style="{{(!$fav)?'display: none':''}}"><a class="rmv-fav" data-item-id="{{$project->id}}" data-url="{{route('rmv-proj-from-fav')}}" title="Remove From Favourite List"><i aria-hidden="true" class="fa fa-heart"></i></a></li>
                                                    <li style="{{($fav)?'display: none':''}}"><a class="add-fav" data-item-id="{{$project->id}}" data-url="{{route('add-proj-to-fav')}}" title="Add To Favourite List"><i aria-hidden="true" class="fa fa-heart-o"></i></a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3 class="sidebar-title"><a href="#">Related Projects</a></h3>
                            <div class="rc-carousel" data-loop="true" data-items="3" data-margin="30" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="true" data-r-small-dots="false" data-r-medium="3" data-r-medium-nav="true" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="true" data-r-large-dots="false">
                                @foreach ($related as $rel)
                                <div class="single-item">
                                    <div class="single-item-wrapper">
                                        <div class="publications-img-wrapper">
                                            <a href="{{route('project',$rel->id)}}"><img class="img-responsive" src="{{asset('img/logo.png')}}" alt="product"></a>
                                        </div>
                                        <div class="publications-content-wrapper">
                                            <h3 class="item-title"><a href="{{route('project',$rel->id)}}">{{$rel->title_en}}</a></h3>
                                            <span class="item-price">{{$rel->subject->name_en}} ({{$rel->study_year}})</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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
                                                <div class="related-img">
                                                    <a href="{{route('project',$mlib->id)}}"><img src="{{asset('img/logo.png')}}" class="img-responsive" alt="related"></a>
                                                </div>
                                                <div class="related-content">
                                                    <p><a href="{{route('project',$mlib->id)}}">{{$mlib->subject->name_en}}</a></p>
                                                    <h4>{{$mlib->title_en}}</h4>
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
                $('.add-fav').attr('style','display:none;');
                $('.rmv-fav').removeAttr('style');
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
                $('.add-fav').removeAttr('style');
                $('.rmv-fav').attr('style','display:none;');
            },
            error: function(e){
                alert(e.responseText);
            }
        });
    });
</script>
@endsection
