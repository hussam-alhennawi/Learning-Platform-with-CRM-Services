<div class="tab-pane fade active in" id="OtherCourses">
    <h3 class="title-section title-bar-high mb-40">Other Courses</h3>
    {{$other_courses->links()}}
    @foreach ($other_courses as $c)
        <div class="course-info">
            <img src="{{url('/photos/courses')}}/{{$c->course->image}}" alt="course" style="width: 30%">
            <h3><a href="{{url('/single-course')}}/{{$c->course->id}}">{{$c->course->title}}</a></h3>
            @if($c->status == "Done")
                <p>You're Done with this course</p>
                <div class="skill-area">
                    <div class="progress">
                        <div data-wow-delay="1.2s" data-wow-duration="1.5s" style="width: 100%; visibility: visible; animation-duration: 1.5s; animation-delay: 1.2s; animation-name: fadeInLeft;" data-progress="100%" class="progress-bar wow fadeInLeft  animated"></div>
                    </div>
                </div>
            @else
                <p>Your request has been sent before in ({{$c->date}}) and it's {{$c->status}}</p>
            @endif
        </div>
        <br>
        <hr>
    @endforeach
</div>

<!-- Start PopUp Script -->
<script>
    $(function () {
        $('.popup-modal').magnificPopup({
            type: 'inline',
            preloader: false,
            focus: '#username',
            modal: true
        });
        $(document).on('click', '.popup-modal-dismiss', function (e) {
            e.preventDefault();
            $.magnificPopup.close();
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });
    });
</script> 
<!-- End PopUp Script -->

<!-- Start Pagination Ajax Request Script -->
<script>
    $('.page-link').click(function(){
        if($(this).attr('data-href'))
        {
            var url = $(this).attr('data-href');
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
        }
    });
</script>
<!-- End Pagination Ajax Request Script -->

<!-- Start Pagination Edit Script -->
<script>
    $('.page-link').each(function(){
        var href = $(this).attr('href');
        $(this).attr('data-href',href);
        $(this).attr('href',"#");
    });
</script>
<!-- End Pagination Edit Script -->