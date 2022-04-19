<canvas id="myChart{{$ChartLabel}}"  height="30vh" width="60vw"></canvas>
<script src="{{asset('js2/Chart.js')}}" integrity="sha512-QEiC894KVkN9Tsoi6+mKf8HaCLJvyA6QIRzY5KrfINXYuP9NxdIkRQhGq3BZi0J4I7V5SidGM3XUQ5wFiMDuWg==" crossorigin="anonymous"></script>
<script>
    var ctx = document.getElementById('myChart{{$ChartLabel}}');
    var labels = [ @foreach($chart as $c) '{{$c->key}}', @endforeach]; 
    var values = [ @foreach($chart as $c) '{{$c->value}}', @endforeach]; 
    var myChart = new Chart(ctx, {
        @if(isset($type))
            @if($type == 'line')
                type: 'line',
            @elseif($type == 'radar')
                type: 'radar',
            @elseif($type == 'pie')
                type: 'pie',
            @elseif($type == 'polarArea')
                type: 'polarArea',
            @elseif($type == 'bubble')
                type: 'bubble',
            @else
                type: 'bar',
            @endif
        @else
            type: 'bar',
        @endif
        // type: 'line',
        // type: 'radar',
        // type: 'pie',
        // type: 'polarArea',
        // type: 'bubble',
        data: {
            labels: labels,
            datasets: [{
                label: '{{$ChartLabel}}',
                data: values,
                backgroundColor: [
                    <?php 
                        $color = ['r'=>0, 'g'=>0, 'b'=>0];
                        $colors = [];
                    ?>
                    @foreach($chart as $c) 
                        <?php 
                            $color['r'] = rand(0,255);
                            $color['g'] = rand(0,255);
                            $color['b'] = rand(0,255);
                            $colors[] = $color;
                        ?>
                        'rgba({{$color['r']}},{{$color['g']}}, {{$color['b']}}, 0.35)'
                        ,        
                    @endforeach
                ],
                borderColor: [
                    <?php $j=0; ?>
                    @foreach($chart as $c) 
                        'rgba({{$colors[$j]['r']}},{{$colors[$j]['g']}}, {{$colors[$j]['b']}}, 1)'
                        <?php $j++; ?>
                        ,        
                    @endforeach
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