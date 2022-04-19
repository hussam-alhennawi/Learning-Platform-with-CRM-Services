@extends('FrontEnd.Public.master')
@section('title',$event->name)
@section('content')
    @include('FrontEnd.Public.white-navbar')

        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area" style="background-image: url('{{asset('img/banner/5.jpg')}}');">
            <div class="container">
                <div class="pagination-area">
                    <h1>Event Details</h1>
                    <ul>
                        <li><a href="{{route('/')}}">Home</a> -</li>
                        <li>Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Event Details Page Area Start Here -->
        <div class="event-details-page-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <div class="event-details-inner">
                            <div class="event-details-img">
                                <div class="countdown-content">
                                    <div id="countdown"></div>
                                </div>
                                <a href="#"><img src="{{url('/photos/events')}}/{{$event->image}}" alt="event" class="img-responsive"></a>
                            </div>
                            <h2 class="title-default-left-bold-lowhight"><a href="#">{{$event->name}}</a></h2>
                            <ul class="event-info-inline title-bar-sm-high">
                                <li><i class="fa fa-calendar" aria-hidden="true"></i>{{date('Y-M-d',strtotime($event->started_at))}}</li>
                                <li><i class="fa fa-map-marker" aria-hidden="true"></i>{{$event->location}}</li>
                            </ul>
                            <p>{{$event->description}}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <div class="sidebar">
                            <div class="sidebar-box">
                                <div class="sidebar-box-inner">
                                    <h4 class="sidebar-title">{{$event->GoingStudents()->count()}} Student Are Going To This Event</h4>
                                    @role(['Internal_student'])
                                        <h3 class="sidebar-title">click here to join</h3>
                                        <div class="sidebar-find-course">
                                            @if($event->started_at > now())
                                            <a class="enroll-btn" href="#reg" id="register-button" onclick="openForm()">{{!($event->going)?"Go To This Event":"Leave This Event"}}</a>
                                            <div class="register-form" id="register-form" style="display: none;">
                                                <div class="title-default-left-bold">{{!($event->going)?"Join":"Leave"}}</div>
                                                <form method="POST" action="{{ route('event.going') }}">
                                                    @csrf
                                                    <input type="hidden" name="event_id" value="{{$event->id}}"/>
                                                    <button class="default-big-btn" type="submit" style="width: auto;padding: 6px 20px;" value="Going">Yes</button>
                                                    <style>
                                                        .form-cancel:hover{
                                                            cursor: pointer;
                                                        }
                                                    </style>
                                                    <a class="default-big-btn form-cancel" style="width: auto;padding: 6px 20px;" onclick="closeForm()">No</a>
                                                </form>
                                            </div>
                                            @else
                                                <a class="enroll-btn" href="#reg" id="register-button" >This Event Ended</a>
                                            @endif
                                        </div>
                                    @endrole
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Event Details Page Area End Here -->

@endsection
@section('Extra-JS')   

    <script>
        $('#countdown').countdown("{{date('Y/m/d H:i:s',strtotime($event->started_at))}}");
    </script>

    <script>
        function openForm() {
        document.getElementById("register-form").style.display = "block";
        }

        function closeForm() {
            document.getElementById("register-form").style.display = "none";
        }
    </script>
@endsection
