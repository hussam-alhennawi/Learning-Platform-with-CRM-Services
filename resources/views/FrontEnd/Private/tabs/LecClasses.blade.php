<div class="tab-pane fade active in" id="Classes">
    <h3 class="title-section title-bar-high mb-40">Classes</h3>
    <div class="orders-info">
        {{$classes->links()}}
        <div class="table-responsive">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Study Year</th>
                        <th>Semester Number</th>
                        <th>Type</th>
                        <th>Number of Students In Class</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($classes as $class)
                        <tr>
                            <td>{{$class->subject->name_en}}</td>
                            <td>{{$class->study_year}}</td>
                            <td>{{$class->semester_number}}</td>
                            <td>{{$class->type}}</td>
                            <?php
                                $records = [];
                                $counts = [];
                                foreach ($class->StudentsRegistredAtClass as $reg)
                                {
                                    $records [$reg->student_id.'|'.$reg->class_id] ['marks'][] = $reg->mark;
                                    $records [$reg->student_id.'|'.$reg->class_id] ['student'] = $reg->student;
                                    $records [$reg->student_id.'|'.$reg->class_id] ['class'] = $reg->class;

                                    if(array_key_exists($reg->student_id.'|'.$reg->class_id,$counts))
                                    {
                                        $counts [$reg->student_id.'|'.$reg->class_id] += 1;
                                    }
                                    else
                                    {
                                        $counts [$reg->student_id.'|'.$reg->class_id] = 1;
                                    }
                                }

                                $maxNum = max($counts);
                            ?>
                            <td>
                                <a href="#myModal{{$class->id}}" class="btn btn-info btn-mini popup-modal">({{count($records)}}) Display <i class="fa fa-external-link-square"></i></a>
                            </td>
                            <td>
                                <a data-href="{{route('ClassLectures',$class->id)}}" class="btn btn-primary btn-mini page-link">(<span class="num-lec-class{{$class->id}}">{{$class->lectures->count()}}</span>) Lectures</a>
                                <a href="#addLec{{$class->id}}" class="btn btn-success btn-mini popup-modal">Add Lecture</a>
                            </td>
                        </tr>
                        <div id="addLec{{$class->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                            <div class="modal-header" style="background-color: #c3c3c3;">
                                <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                    <i class="fa fa-close"></i>
                                </a>
                                <h3>{{$class->subject->name_en}}</h3>
                                <h4>Add New Lecture</h4>
                            </div>
                            <div class="modal-body" style="background-color: #ddd;">
                                <div class="form-data{{$class->id}}">
                                    <div class="control-group{{$errors->has('title')?' has-error':''}}">
                                        <label class="control-label">Title :</label>
                                        <div class="controls">
                                            <input type="text" name="title" value="{{old('title')}}" required>
                                            <span class="text-danger" id="title" style="color: red;">{{$errors->first('title')}}</span>
                                        </div>
                                    </div>
                                    <div class="control-group{{$errors->has('date')?' has-error':''}}">
                                        <label class="control-label">Date :</label>
                                        <div class="controls">
                                            <input type="date" name="date" value="{{old('date')}}" required>
                                            <span class="text-danger" id="date" style="color: red;">{{$errors->first('date')}}</span>
                                        </div>
                                    </div>
                                    <div class="control-group{{$errors->has('pdf_file')?' has-error':''}}">
                                        <label class="control-label">PDF file :</label>
                                        <div class="controls">
                                            <input type="file" name="pdf_file" value="{{old('pdf_file')}}" accept=".pdf">
                                            <span class="text-danger" id="pdf_file" style="color: red;">{{$errors->first('pdf_file')}}</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label"></label>
                                        <div class="controls">
                                            <a class="btn btn-success add-lec" data-item="{{$class->id}}" data-url="{{route('AddLecture')}}">Add</a>
                                        </div>
                                    </div>
                                    <div class="test-output{{$class->id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="myModal{{$class->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                            <div class="modal-header" style="background-color: #c3c3c3;">
                                <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                    <i class="fa fa-close"></i>
                                </a>
                                <h3>{{$class->subject->name_en}}</h3>
                                <h4>{{count($records)}} Students</h4>
                            </div>
                            <div class="modal-body" style="background-color: #ddd;">
                                <canvas id="myChart{{$class->id}}" height="40vh" width="60vw"></canvas>
                            <script>
                                var ctx = document.getElementById('myChart{{$class->id}}');
                                var labels = [ @foreach($records as $st) '{{$st['student']->full_name()}}', @endforeach]; 
                                var myChart = new Chart(ctx, {
                                    // type: 'line',
                                    // type: 'radar',
                                    // type: 'pie',
                                    // type: 'polarArea',
                                    // type: 'bubble',
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [
                                            <?php 
                                                $avg = []; 
                                                $counts = []; 
                                            ?>
                                            @for($i=0;$i<$maxNum;$i++)
                                            {
                                            <?php
                                                $avg[$i] = 0;
                                                $counts[$i] = 0;
                                                $sum = 0;
                                                $count = 0;
                                            ?>
                                            label: 'Round {{$i+1}}',
                                            data: [ @foreach($records as $st) '{{(isset($st['marks'][$i])) ? $st['marks'][$i] : 'null'}}', @endforeach],
                                            backgroundColor: [
                                                <?php 
                                                    $color = ['r'=>0, 'g'=>0, 'b'=>0];
                                                    $colors = [];
                                                ?>
                                                @foreach($records as $st) 
                                                    @if(isset($st['marks'][$i]))
                                                        <?php 
                                                            $color['r'] = rand(0,255);
                                                            $color['g'] = rand(0,255);
                                                            $color['b'] = rand(0,255);
                                                            $colors[] = $color;
                                                            $sum += $st['marks'][$i];
                                                            $count++;
                                                        ?>
                                                        'rgba({{$color['r']/($i+1)}},{{$color['g']/($i+1)}}, {{$color['b']/($i+1)}}, {{($i+1)*0.15}})'
                                                    @else
                                                        'null'
                                                    @endif
                                                    ,        
                                                @endforeach
                                                
                                            ],
                                            borderColor: [
                                                <?php $j=0; ?>
                                                @foreach($records as $st) 

                                                    @if(isset($st['marks'][$i]))
                                                        'rgba({{$colors[$j]['r']/($i+1)}},{{$colors[$j]['g']/($i+1)}}, {{$colors[$j]['b']/($i+1)}}, 1)'
                                                    <?php $j++; ?>
                                                    @else
                                                        'null'
                                                    @endif
                                                    ,        
                                                @endforeach
                                            ],
                                            borderWidth: 1
                                        },
                                        <?php
                                            $avg[$i] = $sum/$count;
                                            $counts[$i] = $count;
                                        ?>
                                        @endfor
                                        ]
                                    },
                                    options: {
                                        scales: {
                                            yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                        }
                                    }
                                });
                            </script>
                            @for($i=0;$i<$maxNum;$i++)
                            <p>
                                AVG (Round {{$i+1}}) = {{number_format($avg[$i], 2, '.', ',')}} 
                                <br>
                                {{$counts[$i]}} Students
                            </p>
                            @endfor
                            <hr>
                                @foreach ($records as $st)
                                <div style="border-bottom: 1px solid #000; padding-bottom: 2px; margin-top: 2px"> 
                                    <div style="min-width: 30vw; display:inline-block">
                                        {{$st['student']->full_name()}}
                                    </div>
                                    <div style="min-width: 30vw; display:inline-block">
                                         ({{implode(",",$st['marks'])}})
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
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

<script>
    $('.add-lec').click(function(){
        var fd = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = $(this).attr('data-url');
        var class_id = $(this).attr('data-item');
        var title = $('.form-data'+class_id).find('input[name="title"]').val();
        var date = $('.form-data'+class_id).find('input[name="date"]').val();
        var elem = $('.form-data'+class_id).find('input[name="pdf_file"]');
        var files = elem[0].files;
        if(files)
            for(var i = 0 , f; f = files[i]; i++)
                var pdf_file = f
        else
            var pdf_file = null;

        fd.append('_token', CSRF_TOKEN);
        fd.append('class_id', class_id);
        fd.append('title', title);
        fd.append('date', date);
        fd.append('pdf_file', pdf_file);

        $.ajax({
            method:"POST",
            url:url,
            cache: false,
            contentType: false,
            processData: false,
            data:fd,
            success: function(response){
                console.log(response);
                console.log(response.message);
                $('.test-output'+class_id).html(response.message);
                $('.num-lec-class'+class_id).html(response.data);
            },
            error: function(e){
                // alert(e.responseText);
                $('.test-output'+class_id).html(e.responseText);
            }
        });
    });
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

<!-- Start Back Link Script -->
<script>
    var lastUrl = getCookie('lastUrl');
    $('.prev-page').each(function(){
        $(this).attr('data-href',lastUrl);
        $(this).attr('href',"#");
    });
</script>
<!-- End Back Link Script -->
