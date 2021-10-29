@extends('dashboards.users.layouts.user-dash-layout')
@section('title','Dashboard')


@section('content')
<div class="flexDiv" style="display:flex;justify-content:space-around;margin:50px">
    <div id="mon-chart" style="width: 900px; height: 700px;">

    </div>

</div>
@endsection


@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Projects', 'Status Count'],
      
        @foreach ($projectsStatus as $ps)
            [ "{{ $ps->status }}", {{ $ps->nb }} ],
        @endforeach
    ]);

    var options = {
      title: 'Projects by status', 
      is3D : true // En 3D
    };

    

    var chart = new google.visualization.PieChart(document.getElementById('mon-chart'));

    chart.draw(data, options);
    

  }
</script>
@endsection
