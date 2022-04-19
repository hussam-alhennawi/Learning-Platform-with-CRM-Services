@extends('FrontEnd.Public.master')
@section('title','Library')
@section('content')
    @include('FrontEnd.Public.white-navbar')
        <!-- Shop Page 1 Area Start Here -->
        <div class="shop-page1-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 col-md-push-3">
                        {{$references->appends(request()->input())->links()}}
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="courses-page-top-area">
                                    <div class="courses-page-top-left">
                                        <p>Showing {{$references->firstItem()}}-{{$references->lastItem()}} of {{$references->total()}} results</p>
                                    </div>
                                    <div class="courses-page-top-right">
                                        <ul>
                                            <li class="active"><a href="#gried-view" data-toggle="tab" aria-expanded="false"><i class="fa fa-th-large"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active shop-page1-xs-width" id="gried-view">
                                    @foreach ($references as $ref)
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                                        <div class="product-box1">
                                            <ul class="product-social">
                                                @if($user && $user->hasRole('Internal_student'))
                                                    <?php $fav = false; ?>
                                                    @foreach ($user->FavouriteReferences as $favRef)
                                                        @if($favRef->reference_id == $ref->id)
                                                            <?php $fav = true; ?>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    <li style="{{(!$fav)?'display: none':''}}"><a class="rmv-fav" data-item-id="{{$ref->id}}" data-url="{{route('rmv-ref-from-fav')}}" title="Remove From Favourite List"><i aria-hidden="true" class="fa fa-heart"></i></a></li>
                                                    <li style="{{($fav)?'display: none':''}}"><a class="add-fav" data-item-id="{{$ref->id}}" data-url="{{route('add-ref-to-fav')}}" title="Add To Favourite List"><i aria-hidden="true" class="fa fa-heart-o"></i></a></li>
                                                @endif
                                                <li><a href="{{Storage::url('PDFfiles/'.$ref->pdf_file)}}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a></li>
                                            </ul>
                                            <div class="product-img-holder">
                                                <a href="{{url('/book')}}/{{$ref->id}}"><img class="img-responsive" src="{{url('/photos/references')}}/{{$ref->image}}" alt="product"></a>
                                            </div>
                                            <div class="product-content-holder" style="height: 120px; overflow: hidden;">
                                                <h3 style="height: 90px; overflow: hidden;"><a href="{{url('/book')}}/{{$ref->id}}">{{$ref->title}}</a></h3>
                                                <span>{{$ref->author}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
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
                                        <form id="checkout-form" method="GET" action="{{url('/library')}}">
                                            <div class="form-group course-name">
                                                <input id="first-name" placeholder="Book Name" name="title" value="{{request()->input('title')}}" class="form-control" type="text" />
                                                <input name="cat" value="{{request()->input('cat')}}" type="hidden" />
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
                                    <h3 class="sidebar-title">Books Categories</h3>
                                    <ul class="sidebar-categories">
                                        <li><a href="{{url('/library')}}">ALL</a></li>
                                        @foreach ($categories as $cat)
                                        <li><a href="{{url('/library')}}/?cat={{$cat->category}}">{{$cat->category}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar-box">
                                <div class="sidebar-box-inner">
                                    <h3 class="sidebar-title">Best Choices</h3>
                                    <div class="sidebar-best-seller-area">
                                        <ul>
                                            @foreach ($bestChoices as $ref)
                                            <li>
                                                <div class="related-img">
                                                    <a href="{{url('/book')}}/{{$ref->id}}"><img src="{{url('/photos/references')}}/{{$ref->image}}" class="img-responsive" alt="related"></a>
                                                </div>
                                                <div class="related-content">
                                                    <h4><a href="{{url('/book')}}/{{$ref->id}}">{{$ref->title}}</a></h4>
                                                    <h5>{{$ref->FavouriteLists()->count()}} Student Liked this</h5>
                                                    <p>{{$ref->author}}</p>
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
    </div>
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