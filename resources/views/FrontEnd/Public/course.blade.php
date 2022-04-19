<!-- Courses 1 Area Start Here -->
<div class="courses1-area" id="Courses">
    <div class="container">
        <h2 class="title-default-left">Featured Courses</h2>
        <a href="{{url('/all_courses')}}" class="view-all-accent-btn">
            VIEW ALL
        </a>
    </div>
    <div id="shadow-carousel" class="container">
        <div class="rc-carousel" data-loop="true" data-items="4" data-margin="20" data-autoplay="false" data-autoplay-timeout="10000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true" data-r-x-small-dots="false" data-r-x-medium="2" data-r-x-medium-nav="true" data-r-x-medium-dots="false" data-r-small="2" data-r-small-nav="true" data-r-small-dots="false" data-r-medium="3" data-r-medium-nav="true" data-r-medium-dots="false" data-r-large="4" data-r-large-nav="true" data-r-large-dots="false">
            @foreach($all_courses as $courses)
                <div class="courses-box1">
                    <div class="single-item-wrapper">
                        <div class="courses-img-wrapper hvr-bounce-to-bottom">
                            <img class="img-responsive" src="{{url('/photos/courses')}}/{{$courses->image}}" alt="courses">
                            <a href="{{url('/single-course')}}/{{$courses->id}}"><i class="fa fa-link" aria-hidden="true"></i></a>
                        </div>
                        <div class="courses-content-wrapper" style="height:300px;">
                            <h3 class="item-title" style="height:70px; overflow:hidden;"><a href="{{url('/single-course')}}/{{$courses->id}}">{{$courses->title}}</a></h3>
                            <p class="item-content" style="height:70px; overflow:hidden;">{{$courses->description}}</p>
                            <a href="{{url('/single-course')}}/{{$courses->id}}">Read More</a>
                            <ul class="courses-info">
                                <li>{{$courses->duration}}
                                    <br><span>Time</span>
                                </li>
                                <li>{{($courses->cost == 0)? 'Free' : '$'.$courses->cost}}
                                    <br><span>Cost</span>
                                </li>
                                <li>{{$courses->rate}}
                                    <br><span>Rate</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Courses 1 Area End Here -->