
<div class="tab-pane fade active in" id="Collages">
    <h3 class="title-section title-bar-high mb-40">Collages Info</h3>
    <div class="orders-info">
        <canvas id="myChart" height="40vh" width="60vw"></canvas>
        <div style="">
            @foreach($collages as $collage)
                <a data-href="{{route('CollageDetails',$collage->id)}}" class="btn btn-primary btn-mini page-link" style="margin-top: 3px">{{$collage->name_en}}</a> 
            @endforeach
        </div>
        <script>
            var ctx = document.getElementById('myChart');
            var labels = [ @foreach($collages as $collage) '{{$collage->name_en}}', @endforeach]; 
            var myChart = new Chart(ctx, {
                // type: 'line',
                type: 'radar',
                // type: 'pie',
                // type: 'polarArea',
                // type: 'bubble',
                // type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Students',
                            data: [ @foreach($collages as $collage) '{{$collage->Students()->count()}}', @endforeach],
                            backgroundColor: [
                                <?php 
                                    $color = ['r'=>0, 'g'=>0, 'b'=>0];
                                    $colors = [];
                                ?>
                                @foreach($collages as $collage) 
                                    <?php 
                                        $color['r'] = rand(0,255);
                                        $color['g'] = rand(0,255);
                                        $color['b'] = rand(0,255);
                                        $colors[] = $color;
                                    ?>
                                    'rgba({{$color['r']}},{{$color['g']}}, {{$color['b']}}, 0.15)'
                                    ,        
                                @endforeach
                            ],
                            borderColor: [
                                <?php $j=0; ?>
                                @foreach($collages as $collage) 
                                    'rgba({{$colors[$j]['r']}},{{$colors[$j]['g']}}, {{$colors[$j]['b']}}, 1)'
                                    <?php $j++; ?>
                                    ,        
                                @endforeach
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'Lecturers',
                            data: [ @foreach($collages as $collage) '{{$collage->Lecturers()->count()}}', @endforeach],
                            backgroundColor: [
                                <?php 
                                    $color = ['r'=>0, 'g'=>0, 'b'=>0];
                                    $colors = [];
                                ?>
                                @foreach($collages as $collage) 
                                    <?php 
                                        $color['r'] = rand(0,255);
                                        $color['g'] = rand(0,255);
                                        $color['b'] = rand(0,255);
                                        $colors[] = $color;
                                    ?>
                                    'rgba({{$color['r']/2}},{{$color['g']/2}}, {{$color['b']/2}}, 0.5)'
                                    ,        
                                @endforeach
                            ],
                            borderColor: [
                                <?php $j=0; ?>
                                @foreach($collages as $collage) 
                                    'rgba({{$colors[$j]['r']/2}},{{$colors[$j]['g']/2}}, {{$colors[$j]['b']/2}}, 1)'
                                    <?php $j++; ?>
                                    ,        
                                @endforeach
                            ],
                            borderWidth: 1
                        },
                        {
                            label: 'Subjects',
                            data: [ @foreach($collages as $collage) '{{$collage->Subjects()->count()}}', @endforeach],
                            backgroundColor: [
                                <?php 
                                    $color = ['r'=>0, 'g'=>0, 'b'=>0];
                                    $colors = [];
                                ?>
                                @foreach($collages as $collage) 
                                    <?php 
                                        $color['r'] = rand(0,255);
                                        $color['g'] = rand(0,255);
                                        $color['b'] = rand(0,255);
                                        $colors[] = $color;
                                    ?>
                                    'rgba({{$color['r']/3}},{{$color['g']/3}}, {{$color['b']/3}}, 0.5)'
                                    ,        
                                @endforeach
                            ],
                            borderColor: [
                                <?php $j=0; ?>
                                @foreach($collages as $collage) 
                                    'rgba({{$colors[$j]['r']/3}},{{$colors[$j]['g']/3}}, {{$colors[$j]['b']/3}}, 1)'
                                    <?php $j++; ?>
                                    ,        
                                @endforeach
                            ],
                            borderWidth: 1
                        },
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

<!-- Start Back Link Script -->
<script>
    var lastUrl = getCookie('lastUrl');
    $('.prev-page').each(function(){
        $(this).attr('data-href',lastUrl);
        $(this).attr('href',"#");
    });
</script>
<!-- End Back Link Script -->