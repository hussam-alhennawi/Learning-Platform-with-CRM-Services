@extends('FrontEnd.Public.master')
@section('title','Courses')
@section('content')
    @include('FrontEnd.Public.white-navbar')
<!-- Inner Page Banner Area Start Here -->
        <div class="inner-page-banner-area" style="background-image: url('img/banner/5.jpg');">
            <div class="container">
                <div class="pagination-area">
                    <h1>Courses</h1>
                    <ul>
                        <li><a href="{{route('/')}}">Home</a> -</li>
                        <li>Course</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Inner Page Banner Area End Here -->
        <!-- Courses Page 1 Area Start Here -->
        <div class="courses-page-area1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 col-md-push-3">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="courses-page-top-area">
                                    <div class="courses-page-top-left">
                                        <p>Showing {{$all_courses->firstItem()}}-{{$all_courses->lastItem()}} of {{$all_courses->total()}} results</p>
                                    </div>
                                    <div class="courses-page-top-right">
                                        <ul>
                                            <li class="active"><a href="#gried-view" data-toggle="tab" aria-expanded="false"><i class="fa fa-th-large"></i></a></li>
                                            <li><a href="#list-view" data-toggle="tab" aria-expanded="true"><i class="fa fa-list"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{$all_courses->appends(request()->input())->links()}}
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="gried-view">
                                  @foreach($all_courses as $courses)
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                        <div class="courses-box1">
                                            <div class="single-item-wrapper">
                                                <div class="courses-img-wrapper hvr-bounce-to-bottom">
                                                    <img class="img-responsive" src="{{url('/photos/courses')}}/{{$courses->image}}" alt="courses">
                                                    <a href="{{url('/single-course')}}/{{$courses->id}}"><i class="fa fa-link" aria-hidden="true"></i></a>
                                                </div>
                                                <div class="courses-content-wrapper" style="height:300px;">
                                                    <h3 class="item-title" style="height:70px; overflow:hidden;"><a href="{{url('/single-course')}}/{{$courses->id}}">{{$courses->title}}</a></h3>
                                                    <p class="item-content" style="height:70px; overflow:hidden;">{{$courses->description}}</p>
                                                    <a href="{{url('/single-course')}}/{{$courses->id}}">Read More</a>
                                                    <ul class="courses-info">
                                                        <li>{{$courses->duration}}
                                                            <br><span> Time</span>
                                                        </li>
                                                        <li>{{($courses->cost == 0)? 'Free' : '$'.$courses->cost}}
                                                            <br><span> Cost</span>
                                                        </li>
                                                        <li>{{$courses->rate}}
                                                            <br><span> Rate</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                              <!-- Listed product show -->
                                <div role="tabpanel" class="tab-pane" id="list-view">
                                  @foreach($all_courses as $courses)
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="courses-box3">
                                            <div class="single-item-wrapper">
                                                <div class="courses-img-wrapper hvr-bounce-to-right">
                                                    <img class="img-responsive" src="{{url('/photos/courses')}}/{{$courses->image}}" alt="courses">
                                                    <a href="{{url('/single-course')}}/{{$courses->id}}"><i class="fa fa-link" aria-hidden="true"></i></a>
                                                </div>
                                                <div class="courses-content-wrapper">
                                                    <h3 class="item-title"><a href="{{url('/single-course')}}/{{$courses->id}}">{{$courses->title}}</a></h3>
                                                    <p class="item-content">{{$courses->description}}</p>
                                                    <a href="{{url('/single-course')}}/{{$courses->id}}">Read More</a>
                                                    <ul class="courses-info">
                                                        <li>{{$courses->duration}}
                                                            <br><span> Time</span>
                                                        </li>
                                                        <li>{{($courses->cost == 0)? 'Free' : '$'.$courses->cost}}
                                                            <br><span> Cost</span>
                                                        </li>
                                                        <li>{{$courses->rate}}
                                                            <br><span> Rate</span>
                                                        </li>
                                                    </ul>
                                                    <div class="courses-fee">{{($courses->cost == 0)? 'Free' : '$'.$courses->cost}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 col-md-pull-9">
                        <div class="sidebar">
                            <div class="sidebar-box">
                                <div class="sidebar-box-inner">
                                    <h3 class="sidebar-title">Find your Course</h3>
                                    <div class="sidebar-find-course">
                                        <form id="checkout-form" method="GET" action="{{route('searchCourse')}}">
                                            <div class="form-group course-name">
                                                <input name="course_name" placeholder="Course Name" name="course" value="{{request()->input('course_name')}}" class="form-control" type="text" />
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-select">
                                                    <select id="district" class='select2' name="cat_id">
                                                        <option value="">Select One</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}" {{(request()->input('cat_id') == $category->id)?"selected":""}}>{{$category->parentCategory->name}}: {{$category->name}} ({{$category->courses()->count()}})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group remember-style">
                                                <span><input name="cost[]" {{(request()->input('cost') && (in_array("PAID",request()->input('cost'))))?"checked":""}} type="checkbox" id="paid-cost" value="PAID">PAID</span>
                                            </div>
                                            <style>
                                                .disabled-slider{
                                                    background: #ddd !important;
                                                }
                                            </style>
                                            <div id="price-range-wrapper" class="price-range-wrapper">
                                                <div id="price-range-filter"></div>
                                                <div class="price-range-select">
                                                    <div class="price-range" id="price-range-min"></div>
                                                    <input type="hidden" name="min_cost" value="{{request()->input('min_cost')}}">
                                                    <div class="price-range" id="price-range-max"></div>
                                                    <input type="hidden" name="max_cost" value="{{request()->input('max_cost')}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button class="sidebar-search-btn disabled" type="submit" value="Search">Search Course</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @if($recomended_courses)
                            <div class="sidebar-box">
                                <div class="sidebar-box-inner">
                                    <h3 class="sidebar-title">Recomended Courses</h3>
                                    <div class="sidebar-best-seller-area">
                                        <ul>
                                            @foreach ($recomended_courses as $rCourse)
                                            <li>
                                                <div class="related-img">
                                                    <a href="{{url('/single-course')}}/{{$rCourse->id}}"><img src="{{url('/photos/courses')}}/{{$rCourse->image}}" class="img-responsive" alt="related"></a>
                                                </div>
                                                <div class="related-content">
                                                    <h4><a href="{{url('/single-course')}}/{{$rCourse->id}}">{{$rCourse->title}}</a></h4>
                                                    <h5>Cost: {{($rCourse->cost == 0)? 'Free' : '$'.$rCourse->cost}}</h5>
                                                    <p>Rate: {{$rCourse->rate}}</p>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="sidebar-box">
                                <div class="sidebar-box-inner">
                                    <h3 class="sidebar-title">Categories</h3>
                                    <ul class="sidebar-categories">
                                        @foreach ($mainCategories as $cat)
                                            <li><a href="{{url('/all_courses')}}/?cat_id={{$cat->id}}">{{$cat->name}}</a></li>                                        
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Courses Page 1 Area End Here -->
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

<script>
    var priceSlider = document.getElementById('price-range-filter');
    if (priceSlider) {
        noUiSlider.create(priceSlider, {
            start: [{{(request()->input('min_cost')?request()->input('min_cost'):$prices["min_price"])}}, {{(request()->input('max_cost')?request()->input('max_cost'):$prices["max_price"])}}],
            connect: true,
            range: {
                'min': {{$prices['min_price']}},
                'max': {{$prices['max_price']}}
            },
            format: wNumb({
                decimals: 0
            }),
        });
        var marginMin = document.getElementById('price-range-min'),
            marginMax = document.getElementById('price-range-max');

        priceSlider.noUiSlider.on('update', function(values, handle) {
            if (handle) {
                marginMax.innerHTML = "$" + values[handle];
                $('input[name="max_cost"]').val(values[handle]);
            } else {
                marginMin.innerHTML = "$" + values[handle];
                $('input[name="min_cost"]').val(values[handle]);
            }
        });
    }

    var paid = document.getElementById('paid-cost');
        
    if(paid.checked) {
        priceSlider.removeAttribute('disabled');
        $('.noUi-handle').removeClass('disabled-slider');
        $('.noUi-connect').removeClass('disabled-slider');
    } else {
        priceSlider.setAttribute('disabled', true);
        $('.noUi-handle').addClass('disabled-slider');
        $('.noUi-connect').addClass('disabled-slider');
        $('input[name="min_cost"]').val(null);
        $('input[name="max_cost"]').val(null);
    }
        
    $('#paid-cost').change(function(){
        
        if(paid.checked) {
            priceSlider.removeAttribute('disabled');
            $('.noUi-handle').removeClass('disabled-slider');
            $('.noUi-connect').removeClass('disabled-slider');
        } else {
            priceSlider.setAttribute('disabled', true);
            $('.noUi-handle').addClass('disabled-slider');
            $('.noUi-connect').addClass('disabled-slider');
            $('input[name="min_cost"]').val(null);
            $('input[name="max_cost"]').val(null);
        }
    });
</script>
@endsection