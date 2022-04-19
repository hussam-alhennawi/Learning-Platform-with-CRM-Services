@extends('FrontEnd.Public.master')
@section('title','Home Page')
@section('content')
    
    @include('FrontEnd.Public.navbar')

    @include('FrontEnd.Public.slider')

    @include('FrontEnd.Public.WelcomeMessage')

    @include('FrontEnd.Public.course')

    @include('FrontEnd.Public.lecturers')

    @include('FrontEnd.Public.event')

@endsection
