<div class="tab-pane fade active in" id="Fav-Lecs">
    <h3 class="title-section title-bar-high mb-40"><a class="prev-page page-link"><i class="fa fa-level-up"></i>Back </a>| Lectures</h3>
    <div class="wishlist-info">
        {{$lectures->links()}}
        <div class="table-responsive">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Class</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>PDF File</th>
                        <th>Check In</th>
                        <th>Favourite</th>
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
                                <?php $check = false ?>
                                @foreach ($lecture->checksIn as $ch)
                                    @if($ch->student_class->student_id == $user->id)
                                        <?php $check = true; ?>
                                        @break
                                    @endif
                                @endforeach
                                {{($check)?'Yes':'No'}}
                            </td>
                            <td class="fav-area">
                                <?php $fav = false ?>
                                @foreach ($user->FavouriteLectures as $favLec)
                                    @if($favLec->lecture_id == $lecture->id)
                                        <?php $fav = true; ?>
                                        @break
                                    @endif
                                @endforeach
                                @if($fav)
                                    <span title="Remove From Favourite List" data-item-id="{{$lecture->id}}" data-url="{{route('rmv-lec-from-fav')}}" class="rmv-fav"><i class="fa fa-heart"></i></span>
                                @else
                                    <span title="Add To Favourite List" data-item-id="{{$lecture->id}}" data-url="{{route('add-lec-to-fav')}}" class="add-fav"><i class="fa fa-heart-o"></i></span>
                                @endif
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

<script>
    $('.rmv-fav').hover(function(){
        $(this).find('i').removeClass('fa-heart');
        $(this).find('i').addClass('fa-heart-o');
        $(this).css('cursor', 'pointer');
    },
    function(){
        $(this).find('i').removeClass('fa-heart-o');
        $(this).find('i').addClass('fa-heart');
        $(this).css('cursor', 'default');
    });
</script>

<script>
    $('.add-fav').hover(function(){
        $(this).find('i').removeClass('fa-heart-o');
        $(this).find('i').addClass('fa-heart');
        $(this).css('cursor', 'pointer');
    },
    function(){
        $(this).find('i').removeClass('fa-heart');
        $(this).find('i').addClass('fa-heart-o');
        $(this).css('cursor', 'default');
    });
</script>

<script>
    $('.rmv-fav').click(function(){
        var url = $(this).attr('data-url');
        var item = $(this).attr('data-item-id');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method:"POST",
            url:url,
            dataType:"json",
            data:{
                _token: CSRF_TOKEN,
                item: item
            },
            success: function(response){
                console.log(response);
                var item_id = response.data;
                $('#'+item_id+'').find('fav-area').html('<span title="Add To Favourite List" data-item-id="'+item_id+'" data-url="{{route("add-lec-to-fav")}}" class="add-fav"><i class="fa fa-heart-o"></i></span>');
            },
            error: function(e){
                alert(e.responseText);
            }
        });
    });
</script>
<script>
    $('.add-fav').click(function(){
        var url = $(this).attr('data-url');
        var item = $(this).attr('data-item-id');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method:"POST",
            url:url,
            dataType:"json",
            data:{
                _token: CSRF_TOKEN,
                item: item
            },
            success: function(response){
                console.log(response);
                var item_id = response.data;
                $('#'+item_id+'').find('.fav-area').html('<span title="Remove From Favourite List" data-item-id="'+item_id+'" data-url="{{route("rmv-lec-from-fav")}}" class="rmv-fav"><i class="fa fa-heart"></i></span>');
            },
            error: function(e){
                alert(e.responseText);
            }
        });
    });
</script>

