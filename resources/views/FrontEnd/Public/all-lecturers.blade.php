@extends('FrontEnd.Public.master')
@section('title','Our Lecturers')
@section('content')
    @include('FrontEnd.Public.white-navbar')
        <!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area" style="background-image: url('img/banner/5.jpg');">
            <div class="container">
                <div class="pagination-area">
                    <h1>Our Lecturers</h1>
                    <ul>
                        <li><a href="{{route('/')}}">Home</a> -</li>
                        <li>Lecturers</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Lecturers Page 1 Area Start Here -->
        <div class="lecturers-page1-area">
            <div class="container">
                <div class="row">
                    @foreach($lecturers as $lecturer)
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="single-item">
                                <div class="lecturers1-item-wrapper">
                                    <div class="lecturers-img-wrapper">
                                        <a href="#"><img class="img-responsive" src="{{url('photos/profiles')}}/{{$lecturer->image}}" alt="team"></a>
                                    </div>
                                    <div class="lecturers-content-wrapper">
                                        <h3 class="item-title"><a href="{{route('user',$lecturer->id)}}">{{$lecturer->full_name()}}</a></h3>
                                        <span class="item-designation">Lecturer At {{$lecturer->LecturerRegistredAtCollage->count()}} Collages</span>
                                        <span class="item-designation">Instuctor In {{$lecturer->courses->count()}} Courses</span>
                                        <ul class="lecturers-social">
                                            <li><a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                            <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {{$lecturers->links()}}
                    </div>
                </div>
            </div>
        </div>
        <!-- Lecturers Page 1 Area End Here -->
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