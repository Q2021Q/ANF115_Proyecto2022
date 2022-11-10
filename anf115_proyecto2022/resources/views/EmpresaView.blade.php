@extends('layouts.app')
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
@section('content')
<h1>Vista Empresa</h1>
<!-- Esta forma es para php nativo -->
<!-- for de tipo blade las mas eficientes integradas en las ultimas verciones de larabel -->
<h2> valor de {{$x}}</h2>
<h2>{{$y}}</h2>

<!-- Salir es el name (->name('salir_salir')) de la ruta  en el archivo web.php en la carpeta routes -->
 <a href="{{route('salir_salir')}}">Salir</a> <!--redireccionar -->
 @endsection
