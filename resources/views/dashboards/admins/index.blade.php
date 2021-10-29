@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title','Dashboard')

@section('content')
<div class="flexDiv" style="display:flex;justify-content:space-around;margin:50px">
    <div id="mon-chart1" style="width: 900px; height: 700px;">

    </div>

    <div id="mon-chart2" style="width: 900px; height: 700px;">

    </div>
</div>
@endsection


@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
    
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart2);

  function drawChart2(){

    var data = google.visualization.arrayToDataTable([
      ['Users', 'Role Count'],
        @foreach ($userssRoles as $ps) // On parcourt les catégories
            [ "{{ $ps->role }}", {{ $ps->nb }} ],
        @endforeach
    ]);

    var options = {
      chart: {
        title: 'Users By Role',
        subtitle: 'Users Roles',
      },
      bars: 'vertical' // Direction "verticale" pour les bars
    };
    

    var chart = new google.charts.Bar(document.getElementById('mon-chart2'));

    chart.draw(data, google.charts.Bar.convertOptions(options));
  }

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Projects', 'Status Count'],
      
        @foreach ($projectsStatus as $ps) // On parcourt les catégories
            [ "{{ $ps->status }}", {{ $ps->nb }} ],
        @endforeach
    ]);

    var options = {
      title: 'Projects by status', // Le titre
      is3D : true // En 3D
    };

    

    var chart = new google.visualization.PieChart(document.getElementById('mon-chart1'));

    chart.draw(data, options);
    

  }
</script>
@endsection
