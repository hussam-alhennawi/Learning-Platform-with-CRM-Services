<div class="tab-pane fade active in" id="Fav-Lecs">
    <h3 class="title-section title-bar-high mb-40">Favourite Lectures</h3>
    <div class="wishlist-info">
        {{$favorite_lecs->links()}}
        <div class="table-responsive">
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
                    @foreach ($favorite_lecs as $l)
                        <tr id="lec{{$l->lecture->id}}">
                            <td>{{$l->lecture->_class->study_year}}: {{$l->lecture->_class->subject->name_en}}-{{$l->lecture->_class->type}}, by: <a href="#">{{$l->lecture->_class->lecturer->full_name()}}</a></td>
                            <td>{{$l->lecture->title}}</td>
                            <td>{{$l->lecture->date}}</td>
                            <td>
                                @if($l->lecture->pdf_file)
                                <a href="{{Storage::url('PDFfiles/'.$l->lecture->pdf_file)}}" target="_blank" class="btn btn-success btn-mini">
                                    Download
                                </a>
                                @else
                                    No file
                                @endif
                            </td>
                            <td>
                                <?php $check = false ?>
                                @foreach ($l->lecture->checksIn as $ch)
                                    @if($ch->student_class->student_id == $user->id)
                                        <?php $check = true; ?>
                                        @break
                                    @endif
                                @endforeach
                                {{($check)?'Yes':'No'}}
                            </td>
                            <td>
                                <span title="Remove From Favourite List" data-item-id="{{$l->lecture->id}}" data-url="{{route('rmv-lec-from-fav')}}" class="rmv-fav"><i class="fa fa-heart"></i></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

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
                $('#'+item_id+'').remove();
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