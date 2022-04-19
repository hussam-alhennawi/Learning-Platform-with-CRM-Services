@extends('FrontEnd.Public.master')
@section('title','Events')
@section('content')
    @include('FrontEnd.Public.white-navbar')

        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area" style="background-image: url('{{asset('img/banner/5.jpg')}}');">
            <div class="container">
                <div class="pagination-area">
                    <h1>Our Upcoming Events</h1>
                    <ul>
                        <li><a href="{{route('/')}}">Home</a> -</li>
                        <li>Events</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Event Page Area Start Here -->
        <div class="event-page-area">
            <div class="container">
                <p>Showing {{$all_events->firstItem()}}-{{$all_events->lastItem()}} of {{$all_events->total()}} results</p>
                {{$all_events->appends(request()->input())->links()}}
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <div class="row event-inner-wrapper">
                            @foreach($all_events as $event)
                            <div class="col-lg-12 col-md-6 col-sm-12 col-xs-6">
                                <div class="single-item">
                                    <div class="item-img">
                                        <a href="{{url('/single_event')}}/{{$event->id}}"><img src="{{url('/photos/events')}}/{{$event->image}}" alt="event" class="img-responsive"></a>
                                    </div>
                                    <div class="item-content">
                                        <h3 class="sidebar-title"><a href="{{url('/single_event')}}/{{$event->id}}">{{$event->name}}</a></h3>
                                        <p>{{$event->description}}</p>
                                        <ul class="event-info-block">
                                            <li><i class="fa fa-calendar" aria-hidden="true"></i>{{date('d M , Y',strtotime($event->started_at))}}</li>
                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i>{{$event->location}}</li>
                                        </ul>
                                    </div>
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
                                        <form id="checkout-form" method="GET" action="{{url('/all_events')}}">
                                            <div class="form-group course-name">
                                                <input id="first-name" placeholder="Type Here . . .." class="form-control" value="{{request()->input('title')}}" name="title" type="text" />
                                            </div>
                                            <div class="form-group">
                                                <button class="sidebar-search-btn-full disabled" type="submit" value="Login">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Event Page Area End Here -->
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