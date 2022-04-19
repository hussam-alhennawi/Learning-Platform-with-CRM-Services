        <!-- Footer Area Start Here -->
        <footer>
            <div class="footer-area-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-box">
                                <a href="{{route('/')}}"><img class="img-responsive" src="{{asset('img/logo.png')}}" alt="logo"></a>
                                <div class="footer-about">
                                    {{-- <p>Praesent vel rutrum purus. Nam vel dui eu sus duis dignissim dignissim. Suspenetey disse at ros tecongueconsequat.Fusce sit amet rna feugiat.</p> --}}
                                </div>
                                {{-- <ul class="footer-social">
                                    <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                </ul> --}}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-box">
                                <h3>Featured Links</h3>
                                <ul class="featured-links">
                                    <li>
                                        <ul>
                                            <li><a href="{{route('/')}}#">Home</a></li>
                                <li><a href="{{route('/')}}#Courses">Courses</a></li>
                                <li><a href="{{route('/')}}#Lecturers">Lecturers</a></li>
                                <li><a href="{{route('/')}}#Ads-Events">Ads & Events</a></li>
                                
                                        </ul>
                                    </li>
                                    <li>
                                        <ul>
                                            <li><a href="#">Library</a>
                                            <ul>
                                                <li><a href="{{route('library')}}">References</a></li>
                                                @role('Internal_student')
                                                <li><a href="{{route('libProjects')}}">Projects</a></li>
                                                @endrole
                                            </ul>
                                        </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-box">
                                <h3>Information</h3>
                                <ul class="corporate-address">
                                    <li><i class="fa fa-phone" aria-hidden="true"></i><a href="Phone:++963 930 011 037"> ++963 930 011 037</a></li>
                                    <li><i class="fa fa-envelope-o" aria-hidden="true"></i><a href="mailto:info@ypu.edu.sy"> info@ypu.edu.sy</a></li>
                                </ul>
                                {{-- <div class="newsletter-area">
                                    <h3>Newsletter</h3>
                                    <div class="input-group stylish-input-group">
                                        <input type="text" placeholder="Enter your e-mail here" class="form-control">
                                        <span class="input-group-addon">
                                                <button type="submit">
                                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                                </button>  
                                            </span>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <div class="footer-box">
                                @if(Auth::user() && Auth::user()->hasRole('Internal_student'))
                                    <h3 class="">Send Us Your Complaint</h3>
                                        <form class="newsletter-area" method="POST" action="{{route('sendComplaint')}}">
                                            @csrf
                                            <textarea placeholder="Message*" class="textarea form-control" name="message" id="sidebar-form-message" rows="3" cols="20" data-error="Message field is required" required></textarea>
                                            <div class="help-block with-errors"></div>
                                            <div class="input-group stylish-input-group">
                                                <span class="input-group-addon">
                                                    <button type="submit">Send</button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <h3>Flickr Photos</h3>
                                    <ul class="flickr-photos">
                                        <li>
                                            <a href="#"><img class="img-responsive" src="{{asset('img/footer/1.jpg')}}" alt="flickr"></a>
                                        </li>
                                        <li>
                                            <a href="#"><img class="img-responsive" src="{{asset('img/footer/2.jpg')}}" alt="flickr"></a>
                                        </li>
                                        <li>
                                            <a href="#"><img class="img-responsive" src="{{asset('img/footer/3.jpg')}}" alt="flickr"></a>
                                        </li>
                                        <li>
                                            <a href="#"><img class="img-responsive" src="{{asset('img/footer/4.jpg')}}" alt="flickr"></a>
                                        </li>
                                        <li>
                                            <a href="#"><img class="img-responsive" src="{{asset('img/footer/5.jpg')}}" alt="flickr"></a>
                                        </li>
                                        <li>
                                            <a href="#"><img class="img-responsive" src="{{asset('img/footer/6.jpg')}}" alt="flickr"></a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-area-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <p>&copy; 2020 YPU All Rights Reserved.</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <p>@if(isset($visitors)){{$visitors}} persons visit this page @endif</p>
                        </div>
                        {{-- <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> --}}
                            {{-- <ul class="payment-method">
                                <li>
                                    <a href="#"><img alt="payment-method" src="{{asset('img/payment-method1.jpg')}}"></a>
                                </li>
                                <li>
                                    <a href="#"><img alt="payment-method" src="{{asset('img/payment-method2.jpg')}}"></a>
                                </li>
                                <li>
                                    <a href="https://theidioms.com"><img alt="Idioms" src="{{asset('img/payment-method3.jpg')}}"></a>
                                </li>
                                <li>
                                    <a href="#"><img alt="payment-method" src="{{asset('img/payment-method4.jpg')}}"></a>
                                </li>
                            </ul> --}}
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Area End Here -->