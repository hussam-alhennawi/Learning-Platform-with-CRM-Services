
<div class="tab-pane fade active in" id="Requests">
    <h3 class="title-section title-bar-high mb-40"><a class="prev-page page-link"><i class="fa fa-level-up"></i>Back </a>| Requests for {{$course->title}}</h3>
    
    <div class="orders-info">
        {{$requests->links()}}
        <div class="table-responsive">
            <a href="#myModal" class="btn btn-info btn-mini popup-modal"><i class="fa fa-bar-chart"></i> Chart </a>
            <div id="myModal" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                <div class="modal-header" style="background-color: #c3c3c3;">
                    <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                        <i class="fa fa-close"></i>
                    </a>
                    <h3>Requests for {{$course->title}}</h3>
                </div>
                <div class="modal-body" style="background-color: #ddd;">
                    @include('FrontEnd.Private.tabs.Chart')                    
                </div>
            </div>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Student</th>
                        <th>Payment Check</th>
                        <th>Status</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $request)
                        <tr id="req{{$request->id}}">
                            <td>{{$request->date}}</td>
                            <td>{{$request->student->full_name()}}</td>
                            <td>
                                @if($request->payment_check)
                                <a href="{{Storage::url('PDFfiles/'.$request->payment_check)}}" target="_blank" class="btn btn-success btn-mini">
                                    Download
                                </a>
                                @else
                                    No file
                                @endif
                            </td>
                            <td class="Status">{{$request->status}}</td>
                            <td class="isActive">{{($request->active)?'Yes':'No'}}</td>
                            
                            <td style="text-align: left;" class="Actions">
                                @if($request->status == "Pending")
                                    <a class="btn btn-success btn-mini accept-req" data-item="{{$request->id}}"  data-url="{{route('AcceptReq')}}">Accept</a>
                                @endif
                                @if(($request->status != "Blocked")&&$request->status != "Done")
                                    <a href="#Block{{$request->id}}" class="btn btn-danger btn-mini popup-modal">Block</a>
                                @endif
                            </td>
                        </tr>
                        <div id="Block{{$request->id}}" class="white-popup-block mfp-hide" style="width: fit-content; margin: 0 auto;">
                            <div class="modal-header" style="background-color: #c3c3c3;">
                                <a href="#" class="popup-modal-dismiss" style="position: fixed; z-index: 8888; font-size: xx-large; left: 30px;">
                                    <i class="fa fa-close"></i>
                                </a>
                                <h3>Are You Sure You Want To Block {{$request->student->full_name()}}</h3>
                                <h4></h4>
                            </div>
                            <div class="modal-body" style="background-color: #ddd;">
                                <a class="btn btn-danger block-req" data-item="{{$request->id}}"  data-url="{{route('BlockReq')}}">Yes</a>
                                <a class="btn btn-primary popup-modal-dismiss">Cancel</a>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $('.accept-req').click(function(){
        var fd = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = $(this).attr('data-url');
        var req_id = $(this).attr('data-item');

        $.ajax({
            method:"POST",
            url:url,
            dataType:"json",
            data:{
                _token:CSRF_TOKEN,
                req_id:req_id
            },
            success: function(response){
                console.log(response);
                console.log(response.message);
                $('#req'+req_id).find('.Actions').html('<a href="#Block'+req_id+'" class="btn btn-danger btn-mini">Block</a>');
                $('#req'+req_id).find('.isActive').html('Yes');
                $('#req'+req_id).find('.Status').html('Active');
            },
            error: function(e){
                alert(e.responseText);
            }
        });
    });
</script>

<script>
    $('.block-req').click(function(){
        var fd = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = $(this).attr('data-url');
        var req_id = $(this).attr('data-item');

        $.ajax({
            method:"POST",
            url:url,
            dataType:"json",
            data:{
                _token:CSRF_TOKEN,
                req_id:req_id
            },
            success: function(response){
                console.log(response);
                console.log(response.message);
                $('#req'+req_id).find('.isActive').html('No');
                $('#req'+req_id).find('.Actions').html('');
                $('#req'+req_id).find('.Status').html('Blocked');
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
