@extends('layouts.app')
    
@section('content')
<head>
    <title>Grafico con Chartjs</title>
</head>
<body>
    <div class="col-lg-12" style="padding-top: 20px;">
        <div class="card">
            <div class="card-header">
                Grafico con Chartjs - prueba 3
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-4">
                        <div>
                            <a href="#" class= "btn btn-primary">Go somewhere</a>
                        </div>
                        <br>
                        <div>
                            <input type="text" name="txtnom" id="txtnom" class="form-control" placeholder="Buscar dato " value="">
                        </div>
                    </div>
                </div>
            </div>
            <div id="datos"></div>
            <script type="text/javascript" src="js/funcion.js"></script>
        </div>
        
    </div>
</body>
@endsection