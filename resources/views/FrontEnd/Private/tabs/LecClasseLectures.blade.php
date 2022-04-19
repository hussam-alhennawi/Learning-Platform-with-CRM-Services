<div class="tab-pane fade active in" id="Fav-Lecs">
    <h3 class="title-section title-bar-high mb-40"><a class="prev-page page-link"><i class="fa fa-level-up"></i>Back </a>| Lectures</h3>
    <div class="wishlist-info">
        {{$lectures->links()}}
        <div class="table-responsive">
            <a href="#myModal" class="btn btn-info btn-mini popup-modal"><i class="fa fa-bar-chart"></i> Chart </a>
            <div id="myModal" class="white-popup-block mfp-hide" style="width: 800px; margin: 0 auto;">
                <div class="modal-header" style="background-color: #c3c3c3;">
                    <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                        <i class="fa fa-close"></i>
                    </a>
                    <h3>Checks In For Lectures</h3>
                </div>
                <div class="modal-body" style="background-color: #ddd;">
                    @include('FrontEnd.Private.tabs.Chart')                    
                </div>
            </div>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>PDF File</th>
                        <th>Check In</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lectures as $lecture)
                        <tr id="lec{{$lecture->id}}">
                            <td>{{$lecture->_class->subject->name_en}}-{{$lecture->_class->type}}</td>
                            <td class="lec-title">{{$lecture->title}}</td>
                            <td class="lec-date">{{$lecture->date}}</td>
                            <td class="lec-file">
                                @if($lecture->pdf_file)
                                <a href="{{Storage::url('PDFfiles/'.$lecture->pdf_file)}}" target="_blank" class="btn btn-success btn-mini">
                                    Download
                                </a>
                                @else
                                    No file
                                @endif
                            </td>
                            <td>
                                <a href="#myModal{{$lecture->id}}" class="btn btn-info btn-mini popup-modal">({{$lecture->checksIn()->count()}}) Display <i class="fa fa-external-link-square"></i></a>
                            </td>
                            <td>
                                <a href="#editLec{{$lecture->id}}" class="btn btn-info btn-mini popup-modal">Edit</a>
                                <a href="#delLec{{$lecture->id}}" class="btn btn-danger btn-mini popup-modal">Delete</a>
                            </td>
                        </tr>
                        <div id="delLec{{$lecture->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                            <div class="modal-header" style="background-color: #c3c3c3;">
                                <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                    <i class="fa fa-close"></i>
                                </a>
                                <h3>Are You Sure You Want To Delete {{$lecture->title}}</h3>
                                <h4></h4>
                            </div>
                            <div class="modal-body" style="background-color: #ddd;">
                                <a class="btn btn-danger delete-lec" data-item="{{$lecture->id}}" data-url="{{route('DeleteLecture')}}">Yes</a>
                                <a class="btn btn-primary popup-modal-dismiss">Cancel</a>
                            </div>
                        </div>
                        <div id="editLec{{$lecture->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                            <div class="modal-header" style="background-color: #c3c3c3;">
                                <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                    <i class="fa fa-close"></i>
                                </a>
                                <h3>{{$lecture->title}}</h3>
                                <h4>Edit Lecture</h4>
                            </div>
                            <div class="modal-body" style="background-color: #ddd;">
                                <div class="form-data{{$lecture->id}}">
                                    <div class="control-group{{$errors->has('title')?' has-error':''}}">
                                        <label class="control-label">Title :</label>
                                        <div class="controls">
                                            <input type="text" name="title" value="{{$lecture->title}}" required>
                                            <span class="text-danger" id="title" style="color: red;">{{$errors->first('title')}}</span>
                                        </div>
                                    </div>
                                    <div class="control-group{{$errors->has('date')?' has-error':''}}">
                                        <label class="control-label">Date :</label>
                                        <div class="controls">
                                            <input type="date" name="date" value="{{$lecture->date}}" required>
                                            <span class="text-danger" id="date" style="color: red;">{{$errors->first('date')}}</span>
                                        </div>
                                    </div>
                                    <div class="control-group{{$errors->has('pdf_file')?' has-error':''}}">
                                        <label class="control-label">PDF file :</label>
                                        <div class="controls pdf-space{{$lecture->id}}">
                                            @if(!$lecture->pdf_file)
                                                <input type="file" name="pdf_file" accept=".pdf"  id="pdf_file{{$lecture->id}}"/>
                                            @else
                                                <span class="text-danger">{{$errors->first('pdf_file')}}</span>
                                                &nbsp;&nbsp;&nbsp;
                                                <a data-item="{{$lecture->id}}" data-url="{{route('delLecPDF')}}" class="btn btn-danger btn-mini delete-lec-pdf">Delete Old file</a>
                                                <a href="{{Storage::url('PDFfiles/'.$lecture->pdf_file)}}" target="_blank" class="btn btn-primary btn-mini">Download</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label"></label>
                                        <div class="controls">
                                            <a class="btn btn-success edit-lec" data-item="{{$lecture->id}}" data-url="{{route('UpdateLecture')}}">Update</a>
                                        </div>
                                    </div>
                                    <div class="test-output{{$lecture->id}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="myModal{{$lecture->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                            <div class="modal-header" style="background-color: #c3c3c3;">
                                <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                    <i class="fa fa-close"></i>
                                </a>
                                <h3>{{$lecture->title}}</h3>
                                <img src="{{Storage::url('QR-codes/'.$lecture->qr_code)}}" width="300">
                                <h4>{{$lecture->checksIn()->count()}} Students Checked In</h4>
                            </div>
                            <div class="modal-body" style="background-color: #ddd;">
                                @foreach ($lecture->checksIn as $ch)
                                    <p class="text-center">{{$ch->student_class->student->full_name()}}</p>
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
    $('.edit-lec').click(function(){
        var fd = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = $(this).attr('data-url');
        var lec_id = $(this).attr('data-item');
        var title = $('.form-data'+lec_id).find('input[name="title"]').val();
        var date = $('.form-data'+lec_id).find('input[name="date"]').val();
        var elem = $('.form-data'+lec_id).find('input[name="pdf_file"]');
        var files = elem[0].files;
        if(files)
            for(var i = 0 , f; f = files[i]; i++)
            {
                var pdf_file = f
                fd.append('pdf_file', pdf_file);
            }
        else
            var pdf_file = null;

        fd.append('_token', CSRF_TOKEN);
        fd.append('lec_id', lec_id);
        fd.append('title', title);
        fd.append('date', date);

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
                $('.test-output'+lec_id).html(response.message);
                $('#lec'+lec_id).find('.lec-title').html(response.data.title);
                $('.form-data'+lec_id).find('input[name="title"]').val(response.data.title);
                $('#editLec'+lec_id).find('h3').html(response.data.title);
                $('#lec'+lec_id).find('.lec-date').html(response.data.date);
                $('.form-data'+lec_id).find('input[name="date"]').val(response.data.date);
                if(response.data.pdf_file)
                    $('#lec'+lec_id).find('.lec-file').html('<a href="{{Storage::url("PDFfiles/")}}'+response.data.pdf_file+'" target="_blank" class="btn btn-success btn-mini">Download</a>');
                else
                    $('#lec'+lec_id).find('.lec-file').html('No file');
                    
                $('.popup-modal').magnificPopup({
                    type: 'inline',
                    preloader: false,
                    focus: '#username',
                    modal: true
                }).magnificPopup('close');
            },
            error: function(e){
                alert(e.responseText);
            }
        });
    });
</script>

<script>
    $('.delete-lec-pdf').click(function(){
        var fd = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = $(this).attr('data-url');
        var lec_id = $(this).attr('data-item');

        $.ajax({
            method:"POST",
            url:url,
            dataType:"json",
            data:{
                _token:CSRF_TOKEN,
                lec_id:lec_id
            },
            success: function(response){
                console.log(response);
                console.log(response.message);
                $('.pdf-space'+lec_id).html('<input type="file" name="pdf_file" accept=".pdf"  id="pdf_file"/>');
                $('#lec'+lec_id).find('.lec-file').html('No file');
            },
            error: function(e){
                alert(e.responseText);
            }
        });
    });
</script>

<script>
    $('.delete-lec').click(function(){
        var fd = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = $(this).attr('data-url');
        var lec_id = $(this).attr('data-item');

        $.ajax({
            method:"POST",
            url:url,
            dataType:"json",
            data:{
                _token:CSRF_TOKEN,
                lec_id:lec_id
            },
            success: function(response){
                console.log(response);
                console.log(response.message);
                $('#lec'+lec_id).remove();
                $('.popup-modal').magnificPopup({
                    type: 'inline',
                    preloader: false,
                    focus: '#username',
                    modal: true
                }).magnificPopup('close');
            },
            error: function(e){
                alert(e.responseText);
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
