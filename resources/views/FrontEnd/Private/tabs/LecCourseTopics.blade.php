<div class="tab-pane fade active in" id="Fav-Lecs">
    <h3 class="title-section title-bar-high mb-40"><a class="prev-page page-link"><i class="fa fa-level-up"></i>Back </a>| Topics</h3>
    <div class="wishlist-info">
        {{$topics->links()}}
        <div class="table-responsive">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topics as $topic)
                        <tr id="topic{{$topic->id}}">
                            <td>{{$topic->course->title}}</td>
                            <td class="topic-name">{{$topic->name}}</td>
                            <td class="topic-desc">{{$topic->description}}</td>
                            <td>
                                <a href="{{route('TopicContents',$topic->id)}}" class="btn btn-info btn-mini page-link">({{$topic->contents()->count()}}) Contents</a>
                            </td>
                            <td>
                                <a href="#editTopic{{$topic->id}}" class="btn btn-info btn-mini popup-modal">Edit</a>
                                <a href="#delTopic{{$topic->id}}" class="btn btn-danger btn-mini popup-modal">Delete</a>
                            </td>
                        </tr>
                        <div id="delTopic{{$topic->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                            <div class="modal-header" style="background-color: #c3c3c3;">
                                <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                    <i class="fa fa-close"></i>
                                </a>
                                <h3>Are You Sure You Want To Delete {{$topic->title}}</h3>
                                <h4></h4>
                            </div>
                            <div class="modal-body" style="background-color: #ddd;">
                                <a class="btn btn-danger delete-topic" data-item="{{$topic->id}}" data-url="{{route('DeleteTopic')}}">Yes</a>
                                <a class="btn btn-primary popup-modal-dismiss">Cancel</a>
                            </div>
                        </div>
                        <div id="editTopic{{$topic->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                            <div class="modal-header" style="background-color: #c3c3c3;">
                                <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                    <i class="fa fa-close"></i>
                                </a>
                                <h3>{{$topic->name}}</h3>
                                <h4>Edit Topic</h4>
                            </div>
                            <div class="modal-body" style="background-color: #ddd;">
                                <div class="form-data{{$topic->id}}">
                                    <div class="control-group{{$errors->has('name')?' has-error':''}}">
                                        <label class="control-label">Name :</label>
                                        <div class="controls">
                                            <input type="text" name="name" value="{{$topic->name}}" style="width: -webkit-fill-available;" required>
                                            <span class="text-danger" id="name" style="color: red;">{{$errors->first('name')}}</span>
                                        </div>
                                    </div>
                                    <div class="control-group{{$errors->has('description')?' has-error':''}}">
                                        <label class="control-label">Description :</label>
                                        <div class="controls">
                                            <input type="text" name="description" value="{{$topic->description}}" style="width: -webkit-fill-available;" required>
                                            <span class="text-danger" id="description" style="color: red;">{{$errors->first('description')}}</span>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="control-label"></label>
                                        <div class="controls">
                                            <a class="btn btn-success edit-topic" data-item="{{$topic->id}}" data-url="{{route('UpdateTopic')}}">Update</a>
                                            <a class="btn btn-primary popup-modal-dismiss">Cancel</a>
                                        </div>
                                    </div>
                                    <div class="test-output{{$topic->id}}">
                                    </div>
                                </div>
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
    $('.edit-topic').click(function(){
        var fd = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = $(this).attr('data-url');
        var topic_id = $(this).attr('data-item');
        var name = $('.form-data'+topic_id).find('input[name="name"]').val();
        var description = $('.form-data'+topic_id).find('input[name="description"]').val();

        fd.append('_token', CSRF_TOKEN);
        fd.append('topic_id', topic_id);
        fd.append('name', name);
        fd.append('description', description);

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
                $('.test-output'+topic_id).html(response.message);
                $('#topic'+topic_id).find('.topic-name').html(response.data.name);
                $('#topic'+topic_id).find('.topic-desc').html(response.data.description);
                $('.form-data'+topic_id).find('input[name="name"]').val(response.data.name);
                $('.form-data'+topic_id).find('input[name="description"]').val(response.data.description);
                $('#editTopic'+topic_id).find('h3').html(response.data.name);
                
                    
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
    $('.delete-topic').click(function(){
        var fd = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = $(this).attr('data-url');
        var topic_id = $(this).attr('data-item');

        $.ajax({
            method:"POST",
            url:url,
            dataType:"json",
            data:{
                _token:CSRF_TOKEN,
                topic_id:topic_id
            },
            success: function(response){
                console.log(response);
                console.log(response.message);
                $('#topic'+topic_id).remove();
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
