
<!-- Ads and Event Area Start Here -->
<div class="news-event-area" id="Ads-Events">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 news-inner-area">
                <h2 class="title-default-left">Latest Ads</h2>
                <ul class="news-wrapper">
                 @foreach($all_Advertisements as $Ad)
                    <li>
                        <div class="news-img-holder">
                            <a href="{{url('/single_advertisements')}}/{{$Ad->id}}"><img src="{{url('/photos/ads')}}/{{$Ad->image}}" class="img-responsive" alt="news"></a>
                        </div>
                        <div class="news-content-holder">
                            <h3><a href="{{url('/single_advertisements')}}/{{$Ad->id}}">{{$Ad->title}}</a></h3>
                            <div class="post-date">{{$Ad->created_at}}</div>
                            <p>{{$Ad->description}}</p>
                        </div>
                    </li>
                 @endforeach
                </ul>
                <div class="news-btn-holder">
                    <a href="{{url('/all_advertisements')}}" class="view-all-accent-btn">View All</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 event-inner-area">
                <h2 class="title-default-left">Upcoming Events</h2>
                <ul class="event-wrapper">
                    @foreach ($ComingEvents as $event)
                        <li class="wow bounceInUp" data-wow-duration="2s" data-wow-delay=".1s">
                            <div class="event-calender-wrapper">
                                <div class="event-calender-holder">
                                    <h3>{{date('d',strtotime($event->started_at))}}</h3>
                                    <p>{{date('M',strtotime($event->started_at))}}</p>
                                    <span>{{date('Y',strtotime($event->started_at))}}</span>
                                </div>
                            </div>
                            <div class="event-content-holder">
                                <h3><a href="{{url('/single_event')}}/{{$event->id}}">{{$event->name}}</a></h3>
                                <p>{{Str::substr($event->description,0,120)}}...</p>
                                <ul>
                                    <li>{{Str::upper(date('h:i a',strtotime($event->started_at)))}} - {{Str::upper(date('h:i a',strtotime($event->ended_at)))}}</li>
                                    <li>{{$event->location}}</li>
                                </ul>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="event-btn-holder">
                    <a href="{{url('/all_events')}}" class="view-all-primary-btn">View All</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Ads and Event Area End Here -->