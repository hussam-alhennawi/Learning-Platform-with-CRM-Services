@extends('FrontEnd.Public.master')
@section('title',$ad->title)
@section('content')
    @include('FrontEnd.Public.white-navbar')

        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area" style="background-image: url('{{asset('img/banner/5.jpg')}}');">
            <div class="container">
                <div class="pagination-area">
                    <h1>{{$ad->title}}</h1>
                    <ul>
                        <li><a href="{{route('/')}}">Home</a> -</li>
                        <li>Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- News Details Page Area Start Here -->
        <div class="news-details-page-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <div class="row news-details-page-inner">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="news-img-holder">
                                    <img src="{{url('/photos/ads')}}/{{$ad->image}}" class="img-responsive" alt="research">
                                    <ul class="news-date1">
                                        <li>{{date('d M',strtotime($ad->created_at))}}</li>
                                        <li>{{date('Y',strtotime($ad->created_at))}}</li>
                                    </ul>
                                </div>
                                <h2 class="title-default-left-bold-lowhight"><a href="{{url('/single_advertisements')}}/{{$ad->id}}">{{$ad->title}}</a></h2>
                                
                                <p><span>{{$ad->description}}</span></p>
                                
                            </div>
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