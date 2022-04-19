@extends('FrontEnd.Public.master')
@section('title',$ref->title)
@section('content')
    @include('FrontEnd.Public.white-navbar')
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area" style="background-image: url('{{asset('img/banner/5.jpg')}}');">
            <div class="container">
                <div class="pagination-area">
                    <h1>{{$ref->title}}</h1>
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
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                        <div class="inner-product-details-left">
                                            <div class="tab-content">
                                                <div class="tab-pane fade active in" id="related1">
                                                    <a href="#" class="zoom ex1"><img alt="single" src="{{url('/photos/references')}}/{{$ref->image}}" class="img-responsive"></a>
                                                </div>
                                            </div>
                                            <ul>
                                                <li class="active">
                                                    <a href="#related1" data-toggle="tab" aria-expanded="false"><img alt="related1" src="{{url('/photos/references')}}/{{$ref->image}}" class="img-responsive"></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                                        <div class="inner-product-details-right">
                                            <h3>{{$ref->title}}</h3>
                                            <p class="price">{{$ref->FavouriteLists()->count()}} Student Liked this</p>
                                            <div class="product-details-content">
                                                <p><span>Author:</span> {{$ref->author}}</p>
                                                <p><span>Publisher:</span> {{$ref->publisher}}({{$ref->publish_year}})</p>
                                                <p><span>Category:</span> {{$ref->category}}</p>
                                            </div>
                                            <ul class="product-details-social">
                                                <li>Share on:</li>
                                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                                            </ul>
                                            <ul class="inner-product-details-cart">
                                                <li><a href="#">Like & Download <i class="fa fa-angle-double-right"></i></a></li>
                                                <li><a href="{{Storage::url('PDFfiles/'.$ref->pdf_file)}}" target="_blank"><i aria-hidden="true" class="fa fa-download"></i></a></li>
                                                @if($user && $user->hasRole('Internal_student'))
                                                    <?php $fav = false; ?>
                                                    @foreach ($user->FavouriteReferences as $favRef)
                                                        @if($favRef->reference_id == $ref->id)
                                                            <?php $fav = true; ?>
                                                            @break
                                                        @endif
                                                    @endforeach
                                                    
                                                    <li><a class="rmv-fav" style="{{(!$fav)?'display: none':''}}" data-item-id="{{$ref->id}}" data-url="{{route('rmv-ref-from-fav')}}" title="Remove From Favourite List"><i aria-hidden="true" class="fa fa-heart"></i></a></li>
                                                    <li><a class="add-fav" style="{{($fav)?'display: none':''}}" data-item-id="{{$ref->id}}" data-url="{{route('add-ref-to-fav')}}" title="Add To Favourite List"><i aria-hidden="true" class="fa fa-heart-o"></i></a></li>
                                                    
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product-details-tab-area">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <ul>
                                            <li class="active"><a href="#description" data-toggle="tab" aria-expanded="false">Description</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="tab-content">
                                            <div class="tab-pane fade active in" id="description">
                                                <p>{{$ref->description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h3 class="sidebar-title"><a href="#">Related Products</a></h3>
                            <div class="rc-carousel" data-loop="true" data-items="3" data-margin="30" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="true" data-r-small-dots="false" data-r-medium="3" data-r-medium-nav="true" data-r-medium-dots="false" data-r-large="3" data-r-large-nav="true" data-r-large-dots="false">
                                @foreach ($related as $rel)
                                <div class="single-item">
                                    <div class="single-item-wrapper">
                                        <div class="publications-img-wrapper">
                                            <a href="#"><img class="img-responsive" src="{{url('/photos/references')}}/{{$rel->image}}" alt="product"></a>
                                        </div>
                                        <div class="publications-content-wrapper">
                                            <h3 class="item-title"><a href="{{url('/book')}}/{{$rel->id}}">{{$rel->title}}</a></h3>
                                            <span class="item-price">{{$rel->author}}</span>
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
                                                    <h4><a href="#">{{$ref->title}}</a></h4>
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
