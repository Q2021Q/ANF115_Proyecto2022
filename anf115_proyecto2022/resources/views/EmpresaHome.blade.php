<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>
<body>
<a href="{{route('empresa_insert')}}">Agregar Empresa</a>
   
        <h1>Empresas</h1>
        <br> 
        <br> 
        <br> 
        <br> 
        <div class="container mt-5">
          
            <div class="row">
            @foreach($listEmpresa as $empresa)
              <div class="col-lg-4" class="card border-secondary mb-3">
                <div class="card" style="height: 25rem;">
                        <div class= "card" class="card border-primary mb-3">
                            <div class="card-header">
                                {{$empresa->NOMBREEMPRESA}}
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                            <a href="{{route('EmpresaGestion', $empresa->IDEMPRESA)}}">
                                <img class = "card-img-top" src="{{asset($empresa->NOMBREFOTOEMPRESA)}}" alt="" class="img-fluid">
                            </a>
                        </div>
                    
                </div>
             </div> 
              @endforeach

           

          </div>
    <br>
    <br>
    <br>
</body>

</html>