<div class="tab-pane fade active in" id="Courses">
    <h3 class="title-section title-bar-high mb-40">Courses</h3>
    <div class="orders-info">
        
        {{$courses->links()}}
        <div class="table-responsive">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Skills</th>
                        <th>Level</th>
                        <th>Duration</th>
                        <th>Cost</th>
                        <th>Rate</th>
                        <th>Students Requestes</th>
                        {{-- <th>Topics</th>
                        <th>Actions</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr class="gradeC">
                        <td> 
                            @if($course->image)
                            <div class="text-center" style="margin:5px;">
                                <img src="{{url('/photos/courses')}}/{{$course->image}}" width="50" alt="course image">
                            </div>
                            @else
                                No Image
                            @endif
                        </td>
                        <td>{{$course->category->name}}</td>
                        <td><a href="{{url('/single-course')}}/{{$course->id}}">{{$course->title}}</a></td>
                        <td>{{$course->description}}</td>
                        <td>{{$course->skills}}</td>
                        <td>{{$course->level}}</td>
                        <td>{{$course->duration}}</td>
                        <td>{{$course->cost}}</td>
                        <td>
                            <?php $counts = 0; ?>
                            @foreach ($course->rates as $rate)
                                @if($rate != 0)
                                    <?php $counts += $rate; ?>
                                @endif
                            @endforeach
                            ({{$course->rate}}) <a href="#myModal{{$course->id}}" class="btn btn-info btn-mini popup-modal"> {{$counts}} rates</a>
                        </td>
                        <td>
                            <a href="{{route('courseRequests',$course->id)}}" class="btn btn-info btn-mini page-link">{{$course->RegisteredStudents()->count()}} requests</a>
                        </td>
                        {{-- <td>
                            <a href="{{route('courseTopics',$course->id)}}" class="btn btn-success btn-mini page-link">{{$course->topics()->count()}} Topics</a>
                        </td>
                        <td style="text-align: left;">
                            <a href="#EditModal{{$course->id}}" class="btn btn-primary btn-mini popup-modal">Edit</a>
                            <a href="#DeleteModal{{$course->id}}" class="btn btn-danger btn-mini popup-modal">Delete</a>
                        </td> --}}
                    </tr>
                    <div id="EditModal{{$course->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                        <div class="modal-header" style="background-color: #c3c3c3;">
                            <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                <i class="fa fa-close"></i>
                            </a>
                            <h3>{{$course->title}}</h3>
                            <h4>Edit This Course</h4>
                        </div>
                        <div class="modal-body" style="background-color: #ddd;">
                            <div class="del-form-data{{$course->id}}">
                                <div class="control-group">
                                    <label class="control-label">Image upload</label>
                                    <div class="controls">
                                        @if($course->image === null)
                                            <input type="file" name="image" accept=".jpg, .jpeg, .png,"  id="image"/>
                                        @else
                                            <input type="hidden" name="countOldMedia" value="{{($course->image === null)?0:1}}"/>
                                            <span class="text-danger">{{$errors->first('image')}}</span>
                                            &nbsp;&nbsp;&nbsp;
                                            <a href="" rel="{{$course->id}}" class="btn btn-danger btn-mini">Delete Old Image</a>
                                            <img src="{{url('/photos/courses')}}/{{$course->image}}" width="100" alt="">
                                        @endif
                                    </div>
                                </div>
                                <div class="control-group{{$errors->has('title')?' has-error':''}}">
                                    <label class="control-label">Title :</label>
                                    <div class="controls">
                                        <input style="width: -webkit-fill-available;" type="text" name="title" id="title" value="{{$course->title}}" required>
                                        <span class="text-danger" id="title" style="color: red;">{{$errors->first('title')}}</span>
                                    </div>
                                </div>                           
                                <div class="control-group{{$errors->has('description')?' has-error':''}}">
                                    <label class="control-label">Description :</label>
                                    <div class="controls">
                                        <textarea style="width: -webkit-fill-available;" name="description" id="description" required>{{$course->description}}</textarea>
                                        <span class="text-danger" style="color: red;">{{$errors->first('description')}}</span>
                                    </div>
                                </div> 
                                <div class="control-group{{$errors->has('skills')?' has-error':''}}">
                                    <label class="control-label">Skills :</label>
                                    <div class="controls">
                                        <textarea style="width: -webkit-fill-available;" name="skills" id="skills" required>{{$course->skills}}</textarea>
                                        <span class="text-danger" style="color: red;">{{$errors->first('skills')}}</span>
                                    </div>
                                </div> 
                                <div class="control-group{{$errors->has('level')?' has-error':''}}">
                                    <label class="control-label">Level :</label>
                                    <div class="controls">
                                        <select style="width: -webkit-fill-available;" name="level" id="level" required>
                                            <option value="None"{{($course->level == 'None')?' selected':''}}>None</option>
                                            <option value="Beginner Level"{{($course->level == 'Beginner Level')?' selected':''}}>Beginner Level</option>
                                            <option value="Intermediate Level"{{($course->level == 'Intermediate Level')?' selected':''}}>Intermediate Level</option>
                                            <option value="Advanced Level"{{($course->level == 'Advanced Level')?' selected':''}}>Advanced Level</option>
                                        </select>
                                        <span class="text-danger" style="color: red;">{{$errors->first('level')}}</span>
                                    </div>
                                </div> 
                                <div class="control-group{{$errors->has('duration')?' has-error':''}}">
                                    <label class="control-label">Duration :</label>
                                    <div class="controls">
                                        <input style="width: -webkit-fill-available;" type="text" name="duration" id="duration" value="{{$course->duration}}" required>
                                        <span class="text-danger" style="color: red;">{{$errors->first('duration')}}</span>
                                    </div>
                                </div> 
                                <div class="control-group{{$errors->has('cost')?' has-error':''}}">
                                    <label class="control-label">Cost :</label>
                                    <div class="controls">
                                        <input style="width: -webkit-fill-available;" type="number" min="0" step="0.01" name="cost" id="cost" value="{{$course->cost}}" required>
                                        <span class="text-danger" id="cost" style="color: red;">{{$errors->first('cost')}}</span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="control-label">Update This Course</label>
                                    <div class="controls">
                                        <a class="btn btn-info del-course" data-item="{{$course->id}}" data-url="{{route('UpdateCourse')}}">Update</a>
                                        <a class="btn btn-primary popup-modal-dismiss">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="DeleteModal{{$course->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                        <div class="modal-header" style="background-color: #c3c3c3;">
                            <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                <i class="fa fa-close"></i>
                            </a>
                            <h3>{{$course->title}}</h3>
                        </div>
                        <div class="modal-body" style="background-color: #ddd;">
                            <div class="del-form-data{{$course->id}}">
                                <div class="control-group">
                                    <label for="control-label">Are You Sure For Delete This Course?</label>
                                    <div class="controls">
                                        <a class="btn btn-danger del-course" data-item="{{$course->id}}" data-url="{{route('DeleteCourse')}}">Delete</a>
                                        <a class="btn btn-primary popup-modal-dismiss">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="myModal{{$course->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                        <div class="modal-header" style="background-color: #c3c3c3;">
                            <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                <i class="fa fa-close"></i>
                            </a>
                            <h3>{{$course->title}}</h3>
                        </div>
                        <div class="modal-body" style="background-color: #ddd;">
                            <canvas id="myChart{{$course->id}}"  height="40vh" width="60vw"></canvas>
                            <script>
                                var ctx = document.getElementById('myChart{{$course->id}}');
                                var labels = [ @foreach($course->rates as $k=>$v) '{{$k}} Stars', @endforeach]; 
                                var values = [ @foreach($course->rates as $k=>$v) '{{$v}}', @endforeach]; 
                                var myChart = new Chart(ctx, {
                                    // type: 'line',
                                    // type: 'radar',
                                    // type: 'pie',
                                    // type: 'polarArea',
                                    // type: 'bubble',
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: '# of Rates',
                                            data: values,
                                            backgroundColor: [
                                                'rgba(255, 99, 132, 0.2)',
                                                'rgba(54, 162, 235, 0.2)',
                                                'rgba(255, 206, 86, 0.2)',
                                                'rgba(75, 192, 192, 0.2)',
                                                'rgba(153, 102, 255, 0.2)',
                                                'rgba(255, 159, 64, 0.2)'
                                            ],
                                            borderColor: [
                                                'rgba(255, 99, 132, 1)',
                                                'rgba(54, 162, 235, 1)',
                                                'rgba(255, 206, 86, 1)',
                                                'rgba(75, 192, 192, 1)',
                                                'rgba(153, 102, 255, 1)',
                                                'rgba(255, 159, 64, 1)'
                                            ],
                                            borderWidth: 1
                                        }]
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
                            <hr>
                            @foreach ($course->AcceptedStudents as $request)
                                @if($request->rate != 0)
                                    <div style="border-bottom: 1px solid #000; padding-bottom: 2px; margin-top: 2px"> 
                                        <div style="min-width: 30vw; display:inline-block">
                                            {{$request->student->full_name()}}
                                        </div>
                                        <div style="min-width: 30vw; display:inline-block">
                                            {{$request->rate}} Stars
                                        </div>
                                    </div>
                                @endif
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
<!-- End Pagination Ajax Request Script -->

<!-- Start Back Link Script -->
<script>

    var lastUrl = getCookie('lastUrl');

    $('.prev-page').each(function(){
        $(this).attr('data-href',lastUrl);
        $(this).attr('href',"#");
    });
</script>
<!-- End Back Link Script -->

<script>
    $('.del-course').click(function(){
        var fd = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = $(this).attr('data-url');
        var course_id = $(this).attr('data-item');
        
        fd.append('_token', CSRF_TOKEN);
        fd.append('course_id', course_id);

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


<script src="{{asset('js2/Chart.js')}}" integrity="sha512-QEiC894KVkN9Tsoi6+mKf8HaCLJvyA6QIRzY5KrfINXYuP9NxdIkRQhGq3BZi0J4I7V5SidGM3XUQ5wFiMDuWg==" crossorigin="anonymous"></script>

