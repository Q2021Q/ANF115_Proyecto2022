@extends('layouts.app')
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
@section('menu')
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('vendors/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SisCont_ANF-2022</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('vendors/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block">Bienvenido Usuario</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <div>
            <!-- <a href="{{route('empresa_insert')}}" class="btn btn-primary">Agregar Empresa</a> -->
        </div>
        </ul>
      </nav>  <!-- /.sidebar-menu -->
    </div>  <!-- /.sidebar -->
</aside>
@endsection

@section('content')

    <!-- Estadísticas gráficos -->
    <figure class="highcharts-figure">
  <div id="container"></div>
  <div id="container2"></div>
    </figure> 
<form action="graficasc/graficosf" method="GET">
  {{csrf_field()}}
  <div class="well">
    <div class="form-group">
      <label for="Desde">Desde:</label>
          <select  name="fechainicio" id="periodoContable"  class="form-select form-select-lg mb-3"  required>
            @foreach ($periodosContable as $periodo)
            <option value="{{$periodo->year}}">{{$periodo->year}}</option>
              @endforeach
              </select>
      <!-- <input type="text" name="fechainicio" id="fini" placeholder="Fecha Inicio"> -->
    </div>
  </div>

  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6">
      <div class="form-group">
        <label for="Hasta">Hasta</label>
          <select  name="fechafin" id="periodoContableB"  class="form-select form-select-lg mb-3"  required>
          @foreach ($periodosContable as $periodo)
          <option value="{{$periodo->year}}">{{$periodo->year}}</option>
          @endforeach
          </select>
        <!-- <input type="text" name="fechafin" id="ffin" placeholder="Fecha Fin"> -->
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6">
      <div class="form-group">
        <label for="cuenta">Cuenta</label>    
        <select  name="codCuenta" id="periodoContableB"  class="form-select form-select-lg mb-3"  required>
          @foreach ($CodCatalogo as $catalogo)
          <option value="{{$catalogo->codigocuenta}}">{{$catalogo->nombrecuenta}}</option>
          @endforeach
          </select>
        
            <br>  
        <input type="hidden" id="idEmpresa" name="idEmpresa" value="{{$idEmpresa}}">
      </div>
    </div>
  </div>
  <input type="submit" value="Buscar" id="buscar-btn">
</form> 

<br>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    Highcharts.chart('container', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Datos de empresa {{$nameEmpresa}} todos los años'
  },
  accessibility: {
    point: {
      valueSuffix: '%'
    }
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
      }
    }
  },
  series: [{
    name: 'Saldo',
    colorByPoint: true,
    data: <?= $data ?>
  }]
});

Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        align: 'left',
        text: ''
    },
    subtitle: {
        align: 'left',
        text: ''
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Cantidad en dolares $'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
    },

    series: [
        {
            name: 'Empresa {{$nameEmpresa}}',
            colorByPoint: true,
            data: <?= $data ?>
        }
      ],
});
</script>

@endsection
