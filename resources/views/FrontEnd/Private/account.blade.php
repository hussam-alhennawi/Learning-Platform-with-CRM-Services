@extends('FrontEnd.Public.master')
@section('title',$user->full_name())
@section('content')
    @include('FrontEnd.Public.white-navbar')
        <!-- Account Page Start Here -->
        <div class="section-space accent-bg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                        <ul class="profile-title">                            
                            @role('superadministrator')
                                <li><a data-href="{{route('SA-Collages')}}">Collages Chart</a></li>
                                <li><a data-href="{{route('SA-Courses')}}">Courses Chart</a></li>
                                <li><a data-href="{{route('SA-References')}}">References Chart</a></li>
                                <li><a data-href="{{route('SA-Events')}}">Events Chart</a></li>
                                <li><a data-href="{{route('SA-Pages')}}">Pages Chart</a></li>
                                <li><a data-href="{{route('SA-Complaints')}}">Complaints</a></li>
                                <li><a href="{{route('management')}}">Management</a></li>
                            @endrole
                            @role(['Internal_student','External_student'])
                                <li><a data-href="{{route('activeCourses')}}">Avtive Courses</a></li>
                                <li><a data-href="{{route('otherCourses')}}">Other Courses</a></li>
                            @endrole
                            @role('Internal_student')
                                <li><a data-href="{{route('Classes')}}">Classes</a></li>
                                <li><a data-href="{{route('Fav-Lecs')}}">Favourite Lectures</a></li>
                                <li><a data-href="{{route('Fav-Refs')}}">Favourite References</a></li>
                                <li><a data-href="{{route('Fav-Projs')}}">Favourite Projects</a></li>
                                <li><a data-href="{{route('scanQR')}}">Scan QR to Check In Lecture</a></li>
                            @endrole
                            @role('Lecturer')
                                <li><a data-href="{{route('LecCourses')}}">Courses</a></li>
                                <li><a data-href="{{route('LecClasses')}}">Classes</a></li>
                                <li><a href="{{route('management')}}">Management</a></li>
                            @endrole
                            @role(['Librarian','Employee'])
                                <li><a href="{{route('management')}}">Management</a></li>
                            @endrole
                            <li><a data-href="{{route('profilePage')}}">Profile</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                        <form class="form-horizontal" id="checkout-form" method="post" action="{{route('profile.update')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="profile-details tab-content">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Account Page End Here -->
@endsection
@section('Extra-JS')
    @if(Session::has('message'))
        <script>
            alert('{{Session::get('message')}}');
        </script>
    @endif

    <script>
        $('.profile-title li').hover(function(){
            $(this).css('cursor', 'pointer');
        },
        function(){
            $(this).css('cursor', 'default');
        });
    </script>

    @role(['superadministrator','Internal_student','External_student','Lecturer'])    
        <script>
            $('.profile-title li').click(function(){
                var url = $(this).find('a').attr('data-href');
                $('.profile-title li').removeClass('active');
                $(this).addClass('active');
                $('.tab-pane').remove();
                $('.tab-content').html('<div style="margin: 0 auto; width: fit-content;"><i class="fa fa-spinner fa-spin fa-5x" aria-hidden="true"></i></div>');
                $.ajax({
                    method:"GET",
                    url:url,
                    dataType:"json",
                    success: function(response){
                        console.log(response);
                        $('.tab-pane').remove();
                        $('.tab-content').html(response.data);
                    },
                    error: function(e){
                        $('.tab-content').html('<div style="margin: 0 auto; width: fit-content;"><div style="margin: 0 auto; width: fit-content;"><i class="fa fa-warning fa-5x" aria-hidden="true"></i></div><p style="font-size: x-large;">'+e.responseText+'</p></div>');
                    }
                });
            });
        </script>
    @endrole
@endsection