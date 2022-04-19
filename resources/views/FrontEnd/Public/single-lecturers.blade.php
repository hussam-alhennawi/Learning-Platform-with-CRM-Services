@extends('FrontEnd.Public.master')
@section('title',$user->full_name())
@section('content')
    @include('FrontEnd.Public.white-navbar')
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area" style="background-image: url('{{asset('img/banner/5.jpg')}}');">
            <div class="container">
                <div class="pagination-area">
                    <h1>Lecturer Details</h1>
                    <ul>
                        <li><a href="{{route('/')}}">Home</a> -</li>
                        <li>Details</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Courses Page 3 Area Start Here -->
        <div class="lecturers-page-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div class="lecturers-contact-info">
                            <img src="{{url('photos/profiles')}}/{{$user->image}}" class="img-responsive" alt="team">
                            <h2>{{$user->full_name()}}</h2>
                            <h3>
                                @forelse ($user->roles as $role)
                                    {{$role->display_name}}
                                    @if (!$loop->last)
                                        <br>
                                    @endif
                                @empty
                                    
                                @endforelse
                            </h3>
                            <ul class="lecturers-social2">
                                <li><a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            </ul>
                            <ul class="lecturers-contact">
                                <li><i class="fa fa-envelope-o" aria-hidden="true"></i>{{$user->email}}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                         
                        <!-- For Lecturers -->
                        @if($user->hasRole('Lecturer'))
                            <h3 class="title-default-left title-bar-big-left-close">Qualifications</h3>
                            <ul class="course-feature2">
                                @foreach ($user->LecturerRegistredAtCollage as $col)
                                    <li>Lecturer At {{$col->collage->name_en}} Collage</li>
                                @endforeach
                            </ul>
                            <h3 class="title-default-left title-bar-big-left-close">Teach Courses</h3>
                            <ul class="course-feature2">
                                @foreach ($user->courses as $course)
                                    <a href="{{url('/single-course')}}/{{$course->id}}"><li>{{$course->title}}</li></a>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Courses Page 3 Area End Here -->
        
@endsection