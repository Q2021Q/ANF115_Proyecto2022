@extends('layouts.app')
<?php
$con = new mysqli ("localhost", "root","","sis_contable_anf115");
$sql = "SELECT saldo, idempresa from cuentageneral";
$res = $con->query($sql);
$con->close();
?>
@section('content')

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['empresa', 'saldo'],
         <?php
            while($fila = $res->fetch_assoc()){
                echo "['".$fila["idempresa"]."',".$fila["saldo"]." ],";
            }
         ?>
        ]);

        var options = {
          title: 'Prueba de Graficos ahuevo',
          legend: 'none',
          pieSliceText: 'label',
          slices: { 1: {offset: 0.4},
                    3: {offset: 0.3},
                    6: {offset: 0.2},
                    9: {offset: 0.1},
          },
        };
        //PieChart, LineChart, BarChart
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>      

@endsection