@extends('FrontEnd.Public.master')
@section('title','Advertisements')
@section('content')
    @include('FrontEnd.Public.white-navbar')

    <!-- Inner Page Banner Area Start Here -->
    <div class="inner-page-banner-area" style="background-image: url('{{asset('img/banner/5.jpg')}}');">
        <div class="container">
            <div class="pagination-area">
                <h1>Advertisments</h1>
                <ul>
                    <li><a href="{{route('/')}}">Home</a> -</li>
                    <li>Ads</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Inner Page Banner Area End Here -->
    <!-- News Page Area Start Here -->
    <div class="news-page-area">
        <div class="container">
            <p>Showing {{$all_Advertisements->firstItem()}}-{{$all_Advertisements->lastItem()}} of {{$all_Advertisements->total()}} results</p>
            {{$all_Advertisements->appends(request()->input())->links()}}
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                    <div class="row">
                        @foreach ($all_Advertisements as $ad)
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="news-box">
                                <div class="news-img-holder">
                                    <img src="{{url('/photos/ads')}}/{{$ad->image}}" class="img-responsive" alt="ad">
                                    <ul class="news-date1">
                                        <li>{{date('d M',strtotime($ad->created_at))}}</li>
                                        <li>{{date('Y',strtotime($ad->created_at))}}</li>
                                    </ul>
                                </div>
                                <h2 class="title-default-left-bold"><a href="{{url('/single_advertisements')}}/{{$ad->id}}">{{$ad->title}}</a></h2>
                                
                                <p>{{$ad->description}}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="sidebar">
                        <div class="sidebar-box">
                            <div class="sidebar-box-inner">
                                <h3 class="sidebar-title">Search</h3>
                                <div class="sidebar-find-course">
                                    <form id="checkout-form" method="GET" action="{{url('/all_advertisements')}}">
                                        <div class="form-group course-name">
                                            <input id="first-name" name="name" value="{{request()->input('name')}}" placeholder="Type Here . . .." class="form-control" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <button class="sidebar-search-btn-full disabled" type="submit" value="Login">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-box">
                            <div class="sidebar-box-inner">
                                <h3 class="sidebar-title">Latest Ads</h3>
                                <div class="sidebar-latest-research-area">
                                    <ul>
                                        @foreach ($last_ads as $ad)
                                        <li>
                                            <div class="latest-research-img">
                                                <a href="{{url('/single_advertisements')}}/{{$ad->id}}"><img src="{{url('/photos/ads')}}/{{$ad->image}}" class="img-responsive" alt="skilled"></a>
                                            </div>
                                            <div class="latest-research-content">
                                                <h4>{{date('d M, Y',strtotime($ad->created_at))}}</h4>
                                                <p>{{$ad->title}}</p>
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
    <!-- News Page Area End Here -->
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
@endsection