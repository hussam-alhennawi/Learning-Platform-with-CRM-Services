
<div class="tab-pane fade active in" id="Classes">
    <h3 class="title-section title-bar-high mb-40">Classes</h3>
    <div class="orders-info">
        {{$classes->links()}}
        <div class="table-responsive">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Lecturer</th>
                        <th>Study Year</th>
                        <th>Semester Number</th>
                        <th>Type</th>
                        <th>Marks For ({{$user->full_name()}})</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $class)
                        <tr>
                            <td>{{$class->subject->name_en}}</td>
                            <td><a href="{{route('user',$class->lecturer->id)}}">{{$class->lecturer->full_name()}}</a></td>
                            <td>{{$class->study_year}}</td>
                            <td>{{$class->semester_number}}</td>
                            <td>{{$class->type}}</td>
                            <?php
                                $records = [];
                                foreach ($class->StudentsRegistredAtClass as $reg)
                                {
                                    if(array_key_exists($reg->student_id.'|'.$reg->class_id,$records))
                                    {
                                        $records [$reg->student_id.'|'.$reg->class_id] ['marks'] .=' , '.$reg->mark;
                                        $records [$reg->student_id.'|'.$reg->class_id] ['student'] = $reg->student;
                                        $records [$reg->student_id.'|'.$reg->class_id] ['class'] = $reg->class;
                                    }
                                    else 
                                    {
                                        $records [$reg->student_id.'|'.$reg->class_id] ['marks'] = $reg->mark;
                                        $records [$reg->student_id.'|'.$reg->class_id] ['student'] = $reg->student;
                                        $records [$reg->student_id.'|'.$reg->class_id] ['class'] = $reg->class;
                                    }
                                }
                            ?>
                            <td>{{$records[$user->id.'|'.$class->id]['marks']}}</td>
                            <td>
                                <a data-href="{{route('StudClassLectures',$class->id)}}" class="btn btn-primary btn-mini page-link">(<span class="num-lec-class{{$class->id}}">{{$class->lectures->count()}}</span>) Lectures</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
        
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function checkCookie() {
        var user = getCookie("username");
        if (user != "") {
            alert("Welcome again " + user);
        } else {
            user = prompt("Please enter your name:", "");
            if (user != "" && user != null) {
            setCookie("username", user, 365);
            }
        }
    }
</script>

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
            var thisUrl = '{{request()->fullUrl()}}';
            setCookie('lastUrl',thisUrl,1);
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