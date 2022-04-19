@extends('FrontEnd.Public.master')
@section('title','404')
@section('content')
    @include('FrontEnd.Public.white-navbar')
        <div class="inner-page-banner-area" style="background-image: url('{{url('img/banner/5.jpg')}}');">
            <div class="container">
                <div class="pagination-area">
                    <h1>404 Error</h1>
                    <ul>
                        <li><a href="#">Home</a> -</li>
                        <li>Error</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Error Page Area Start Here -->
        <div class="error-page-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="error-top">
                            <img src="{{url('img/404.png')}}" class="img-responsive" alt="404">
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="error-bottom">
                            <h2>Sorry!!! Page Was Not Found</h2>
                            <p>The page you are looking is not available or has been removed. Try going to Home Page by using the button below.</p>
                            <a href="{{route('/')}}" class="default-white-btn">Go To Home Page</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Error Page Area End Here -->
@endsection