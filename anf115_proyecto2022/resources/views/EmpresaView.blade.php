<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresa</title>
</head>

<body> -->
@extends('layouts.app')
@section('content')
<h1>Vista Empresa</h1>
<!-- Esta forma es para php nativo -->
<!-- for de tipo blade las mas eficientes integradas en las ultimas verciones de larabel -->
<h2> valor de {{$x}}</h2>
<h2>{{$y}}</h2>

<!-- Salir es el name (->name('salir_salir')) de la ruta  en el archivo web.php en la carpeta routes -->
 <a href="{{route('salir_salir')}}">Salir</a> <!--redireccionar -->
 @endsection


<!-- </body>
</html> -->