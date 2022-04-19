<!-- Header Area Start Here -->
<header>
    <div id="header2" class="header2-area">
        <div class="header-top-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="header-top-left">
                            <ul>
                                <li><i class="fa fa-phone" aria-hidden="true"></i><a href="Tel:+1234567890">++963 930 011 037 </a></li>
                                <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="#">info@ypu.edu.sy</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="header-top-right">
                            <ul>
                                @guest
                                <li>
                                    <a class="login-btn-area" href="#" id="login-button"><i class="fa fa-lock" aria-hidden="true"></i> Login</a>
                                    <div class="login-form" id="login-form" style="display: none;">
                                        <div class="title-default-left-bold">Login</div>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <label>Username*</label>
                                            <input type="text" placeholder="username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus />
                                        
                                            @if ($errors->has('username'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('username') }}</strong>
                                            </span>
                                            @endif

                                            <label>Password *</label>
                                            <input type="password" placeholder="Password"  class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required />
                                            
                                            @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                            @endif
                                            <span style="display: block"><input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}/>Remember Me</span></br>
                                            <div>
                                                <label class="check" style="width: fit-content">{{ __('Forgot Your Password?') }}</label>
                                                <a style="padding: 0; color: #002147; display: inline-block;" href="{{ route('password.request') }}">
                                                    Reset
                                                </a>
                                            </div>
                                            <button class="default-big-btn" type="submit" value="Login">{{ __('Login') }}</button>
                                            <button class="default-big-btn form-cancel" type="submit" value="">Cancel</button>
                                        </form>
                                    </div>
                                </li>
                                <li>
                                    <div class="apply-btn-area">
                                        <a href="{{route('register')}}" class="apply-now-btn">Register Now</a>
                                    </div>
                                </li>
                                @else
                                <li>
                                    <a href="{{ route('logout') }}" class="login-btn-area"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"
                                            id="login-button">Log out</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                </li>
                                <li>
                                    <div class="apply-btn-area">
                                        <a class="apply-now-btn" href="{{route('account')}}" style="">{{Auth::user()->first_name}}</a>
                                    </div>
                                </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-menu-area bg-textPrimary" id="sticker">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-3">
                        <div class="logo-area">
                            <a href="{{route('/')}}"><img class="img-responsive" src="{{asset('img/logo.png')}}" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9">
                        <nav id="desktop-nav">
                            <ul><li><a href="{{route('/')}}#">Home</a></li>
                                <li><a href="{{route('/')}}#Courses">Courses</a></li>
                                <li><a href="{{route('/')}}#Lecturers">Lecturers</a></li>
                                <li><a href="{{route('/')}}#Ads-Events">Ads & Events</a></li>
                                <li><a href="#">Library</a>
                                    <ul>
                                        <li><a href="{{route('library')}}">References</a></li>
                                        @role('Internal_student')
                                        <li><a href="{{route('libProjects')}}">Projects</a></li>
                                        @endrole
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    {{-- <div class="col-lg-1 col-md-1 hidden-sm">
                        <div class="header-search">
                            <form>
                                <input type="text" class="search-form" placeholder="Search...." required="">
                                <a href="#" class="search-button" id="search-button"><i class="fa fa-search" aria-hidden="true"></i></a>
                            </form>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area Start -->
    <div class="mobile-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul><li><a href="{{route('/')}}#">Home</a></li>
                                <li><a href="{{route('/')}}#Courses">Courses</a></li>
                                <li><a href="{{route('/')}}#Lecturers">Lecturers</a></li>
                                <li><a href="{{route('/')}}#Ads-Events">Ads & Events</a></li>
                                <li><a href="#">Library</a>
                                    <ul>
                                        <li><a href="{{route('library')}}">References</a></li>
                                        @role('Internal_student')
                                        <li><a href="{{route('libProjects')}}">Projects</a></li>
                                        @endrole
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Mobile Menu Area End -->
</header>
<!-- Header Area End Here -->