@extends('FrontEnd.Public.master')
@section('title',$content->title)
@section('content')
    @include('FrontEnd.Public.white-navbar')
<!-- Inner Page Banner Area Start Here -->
<div class="inner-page-banner-area" style="background-image: url('{{asset('img/banner/5.jpg')}}');">
    <div class="container">
        <div class="pagination-area">
            <h1>{{$content->title}}</h1>
            <ul>
                <li><a href="{{route('/')}}">Home</a> - </li>
                <li><a href="{{url('/single-course')}}/{{$course->id}}">{{$course->title}}</a> - </li>
                <li>{{$content->topic->name}}</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Inner Page Banner Area End Here -->

<div class="courses-page-area5">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <div class="course-details-inner">
                    <h2 class="title-default-left title-bar-high">{{$content->title}}</h2>
                    <style>
                        video{
                            width: 802px;
                            height: 400px;
                        }
                        .view-all-primary-btn:hover {
                            cursor: pointer;
                        }
                    </style>
                    <video id="myVideo" class="video" controls>
                        <source src="{{Storage::url('ContentsVideos/'.$content->video_file)}}" type="video/mp4">
                    </video>
                    <p>{{$content->description}}</p>
                    <div class="countdown-content" style="display: none; margin:0 auto; width: fit-content; padding: 3px;">
                        <p  style="margin: 2px auto; display: block; width: fit-content;">
                            <i class="fa fa-spinner fa-spin fa-3x" aria-hidden="true"></i>
                        </p>
                        <div id="countdown2">
                        </div>
                        <div class="view-all-primary-btn cancel-next" style="margin: 2px auto; display: block;">Cancel</div>
                        <div class="view-all-primary-btn play-now" style="margin: 2px auto; display: block;">Play Next</div>
                    </div>
                    <div class="congrates" style="display: none">
                        <h2>Congratulations <i class="fa fa-hand-peace-o"></i></h2>
                        <h3>You finished this course successfully</h3>
                    </div>
                    <div class="course-details-tab-area">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                <div class="sidebar">
                    <div class="sidebar-box">
                        <div class="sidebar-box-inner" id="cou">
                            <h3 class="sidebar-title">Course Topics</h3>
                            <div class="sidebar-course-price">
                                @foreach ($course->topics as $topic)
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="panel-title">
                                                <a aria-expanded="{{($content->topic_id == $topic->id)?'true':'false'}}" class="accordion-toggle {{($content->topic_id == $topic->id)?'':'collapsed'}}" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$topic->id}}">
                                                    <ul>
                                                        <li>{{$topic->name}}</li>
                                                    </ul>
                                                </a>
                                            </div>
                                        </div>
                                        <div aria-expanded="{{($content->topic_id == $topic->id)?'true':'false'}}" id="collapse{{$topic->id}}" role="tabpanel" class="panel-collapse collapse {{($content->topic_id == $topic->id)?'in':''}}">
                                            <div class="panel-body">
                                                <ul>
                                                    @foreach($topic->contents as $cont)
                                                        <hr>
                                                        <li>
                                                            <a href="{{url('/content')}}/{{$cont->id}}">
                                                                @if($content->id == $cont->id)
                                                                <i class="fa fa-arrow-circle-right" title="You are here now"></i>
                                                                @endif
                                                                {{$cont->title}}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <a href="{{Storage::url('ContentsAppendixFiles/'.$content->appendix)}}" target="_blank" class="download-btn">Download Appendix</a>
                            </div>
                        </div>
                    </div>
                    @role(['Internal_student'])
                    <div class="sidebar-box">
                        <div class="sidebar-box-inner">
                            <h3 class="sidebar-title">Send Us Your Complaint</h3>
                            <div class="sidebar-question-form">
                                <form method="POST" action="{{route('sendComplaint')}}">
                                    <fieldset>
                                        <div class="form-group">
                                            <textarea placeholder="Message*" class="textarea form-control" name="message" id="sidebar-form-message" rows="3" cols="20" data-error="Message field is required" required></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="default-full-width-btn">Send</button>
                                        </div>
                                        <div class='form-response'></div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Extra-JS')    
    @if($content->next())
        <script type='text/javascript'>
            document.getElementById('myVideo').addEventListener('ended',myHandler,false);
            function myHandler(e) {
                var delay = 10000; 
                $('#countdown2').countdown(Date.now()+delay, {elapse: true})
                .on('update.countdown', function(event) {
                    $('.countdown-content').css('display','block');
                    var $this = $(this);
                    if(event.elapsed) 
                    {
                        $('#countdown2').css('display','none');
                        window.location = "{{route('courseVideos',$content->next()->id)}}";
                    } 
                    else 
                    {
                        $this.html(event.strftime('Next Video Will Play In <span>%S</span> Secounds'));
                    }
                });
            }

            $('.cancel-next').click(function(){
                $('#countdown2').countdown('pause');
                $('#countdown2').remove();
                $('.cancel-next').remove();
                $('.fa-spinner').remove();
            });

            $('.play-now').click(function(){
                window.location = "{{route('courseVideos',$content->next()->id)}}";
            });
        </script>
    @else
        <script type='text/javascript'>
            document.getElementById('myVideo').addEventListener('ended',myHandler,false);
            function myHandler(e) {
                $('.congrates').css('display','block');
            }
        </script>
    @endif
@endsection