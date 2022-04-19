<!doctype html>
<html class="no-js" lang="">

@include('FrontEnd.Public.header_stream')

<!-- Main Body Area End Here -->
<body>

@yield('content')

@include('FrontEnd.Public.footer')

@include('FrontEnd.Public.footer_stream')
    
@yield('Extra-JS')

</body>

</html>
