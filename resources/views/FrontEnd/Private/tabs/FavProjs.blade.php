<div class="tab-pane fade active in" id="Fav-Projs">
    <h3 class="title-section title-bar-high mb-40">Favourite Projects</h3>
    <div class="wishlist-info">
        {{$favorite_projs->links()}}
        <div class="table-responsive">
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Arabic Title</th>
                        <th>English Title</th>
                        <th>Study Year</th>
                        <th>Subject</th>
                        <th>Students</th>
                        <th>SuperVisors</th>
                        <th>PDF File</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($favorite_projs as $p)
                        <tr id="proj{{$p->lib_project->id}}">
                            <td>{{$p->lib_project->title_ar}}</td>
                            <td>{{$p->lib_project->title_en}}</td>
                            <td>{{$p->lib_project->study_year}}</td>
                            <td>{{$p->lib_project->subject->name_en}}</td>
                            <td>
                                @forelse ($p->lib_project->students as $student)
                                    {{$student->full_name()}}
                                    @if (!$loop->last)
                                        ,<br>
                                    @endif
                                @empty
                                    No Students
                                @endforelse
                            </td>
                            <td>
                                @forelse ($p->lib_project->supervisors as $supervisor)
                                    <a href="{{route('user',$supervisor->id)}}">{{$supervisor->full_name()}}</a>
                                    @if (!$loop->last)
                                        ,<br>
                                    @endif
                                @empty
                                    No Supervisors
                                @endforelse
                            </td>
                            <td>
                                @if($p->lib_project->pdf_file)
                                <a href="{{Storage::url('PDFfiles/'.$p->lib_project->pdf_file)}}" target="_blank" class="btn btn-success btn-mini">
                                    Download
                                </a>
                                @else
                                    No file
                                @endif
                            </td>
                            <td>
                                <span title="Remove From Favourite List" data-item-id="{{$p->lib_project->id}}" data-url="{{route('rmv-proj-from-fav')}}" class="rmv-fav"><i class="fa fa-heart"></i></span>
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