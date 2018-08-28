@foreach($answers as $key=>$answer)
<div style="margin:0 20px;">
<canvas id="myChart_{{$loop->index}}" width="400" max-height="400"></canvas>
<br/><br/><br/><br/><br/>
</div>
<script>
    $(function () {
        var ctx = document.getElementById("myChart_{{$loop->index}}").getContext('2d');
        new Chart(ctx,{
            "type":"horizontalBar",
            "data":{
                "labels":[
                    @foreach($answer as $k=>$v)
                    "{{$k}}",
                    @endforeach
                ],
                "datasets":[{
                    "label":"{{$key}}",
                    "data":[
                        @foreach($answer as $k=>$v)
                            {{$v}},
                        @endforeach
                    ],
                    "fill":false,
                    "backgroundColor":[
                        "rgba(255, 99, 132, 0.2)",
                        "rgba(255, 159, 64, 0.2)",
                        "rgba(255, 205, 86, 0.2)",
                        "rgba(75, 192, 192, 0.2)",
                        "rgba(54, 162, 235, 0.2)",
                        "rgba(153, 102, 255, 0.2)",
                        "rgba(201, 203, 207, 0.2)"
                    ],
                    "borderColor":[
                        "rgb(255, 99, 132)",
                        "rgb(255, 159, 64)",
                        "rgb(255, 205, 86)",
                        "rgb(75, 192, 192)",
                        "rgb(54, 162, 235)",
                        "rgb(153, 102, 255)",
                        "rgb(201, 203, 207)"
                    ],
                    "borderWidth":1
                }]
            },
            "options":{
                "scales":{
                    "xAxes":[{
                        "ticks":{"beginAtZero":true}
                    }]
                }
            }
        });
    });
</script>
@endforeach