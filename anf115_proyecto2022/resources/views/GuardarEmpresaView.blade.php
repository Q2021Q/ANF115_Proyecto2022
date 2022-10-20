<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Agregar una empresa</h1>
<form action="{{route('guardar_empresa')}}" method = "POST">
    {{csrf_field()}}
    <div>

        <label for="empresa">Codigo de Empresa
            @if($errors->first('empresa'))
            <p class = 'text-danger'>{{$errors->first('empresa')}}</ide>
             @endif   
        </label>
        <input type="text" name="empresa" id="empresa">
        <br>
        <br>

        <label for="nombreEmpresa">Nombre de la empresa
            @if($errors->first('nombreEmpresa'))
            <p class = 'text-danger'>{{$errors->first('nombreEmpresa')}}</ide>
             @endif   
    </label>                                                     <!--  mantiene el valor cuando se introduce un dato erroneo --> 
        <input type="text" name="nombreEmpresa" id="nombreEmpresa" value="{{old('nombreEmpresa')}}">
        <br>
        <br>

        <label for="rubro">Sector de la empresa
            @if($errors->first('rubro'))
            <p class = 'text-danger'>{{$errors->first('rubro')}}</ide>
             @endif   
        </label>
        <input type="text" name="rubro" id="rubro">
        <br>
        <br>

        <input type="submit" value="Guardar">
    </div>
</form>

</body>
</html>