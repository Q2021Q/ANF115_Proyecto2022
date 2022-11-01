<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga File</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

</head>
<body>
<a href="{{route('home_empresa')}}">HOME</a>
    <h1 style="text-align:center">{{$nomEmpresa}}</h1>

    <!-- Agregar este imput dentro del formulario para recuperar el id de la empresa -->
    <input type="text" value="{{$idEmpresa}}" id="idEmpresa" name="idEmpresa" style="display: none">

    <form action="">

    <div class="container mt-5">
          
        <div class="row">

            <div class="col-lg-3" class="card border-secondary mb-3">
              <div class="card" style="height: 20rem;">
                      <div class= "card" class="card border-primary mb-3">
                          <div class="card-header">
                            <p>Cargar Catalogo de Cuentas</p>
                          </div>
                      </div>
                      <div class="card-body" class="card-body text-secondary">
                          <a href="{{route('importar_catalogo', $idEmpresa)}}">
                            <img class = "card-img-top" src="{{asset('imagenes/catalogoIMG.png')}}" alt="" class="img-fluid">
                          </a>
                      </div>
                  
              </div>
           </div> 
           
           <div class="col-lg-3" class="card border-secondary mb-3">
              <div class="card" style="height: 20rem;">
                      <div class= "card" class="card border-primary mb-3">
                          <div class="card-header">
                            <p>Cargar Balance General</p>
                          </div>
                      </div>
                      <div class="card-body" class="card-body text-secondary">
                          <a href="{{route('importar_balance_get', $idEmpresa)}}">
                             <img class = "card-img-top" src="{{asset('imagenes/balanceIMG.png')}}" alt="" class="img-fluid">
                          </a>
                      </div>
                  
              </div>
           </div>

           <div class="col-lg-3" class="card border-secondary mb-3">
              <div class="card" style="height: 20rem;">
                      <div class= "card" class="card border-primary mb-3">
                          <div class="card-header">
                            <p>Cargar Estado de Resultados</p>
                          </div>
                      </div>
                      <div class="card-body" class="card-body text-secondary">
                          <a  href="{{route('importar_estado_resultados', $idEmpresa)}}">
                              <img class = "card-img-top" src="{{asset('imagenes/estadoResultado.jpg')}}" alt="" class="img-fluid">
                          </a>
                      </div>
                  
              </div>
           </div>

           <div class="col-lg-3" class="card border-secondary mb-3">
              <div class="card" style="height: 20rem;">
                      <div class= "card" class="card border-primary mb-3">
                          <div class="card-header">
                            <p>Cuentas de Estados Financieros</p>
                          </div>
                      </div>
                      <div class="card-body" class="card-body text-secondary">
                          <a>
                            <img class = "card-img-top" src="{{asset('imagenes/cuentaIMG.png')}}" alt="" class="img-fluid">
                          </a>
                      </div>
                  
              </div>
         </div>
         
         <div class="col-lg-3" class="card border-secondary mb-3">
              <div class="card" style="height: 20rem;">
                      <div class= "card" class="card border-primary mb-3">
                          <div class="card-header">
                            <p>Cuentas de Catalogo</p>
                          </div>
                      </div>
                      <div class="card-body" class="card-body text-secondary">
                          <a>
                            <img class = "card-img-top" src="{{asset('imagenes/cuentaCatalogo.jpg')}}" alt="" class="img-fluid">
                          </a>
                      </div>
                  
              </div>
         </div>

         <div class="col-lg-3" class="card border-secondary mb-3">
              <div class="card" style="height: 20rem;">
                      <div class= "card" class="card border-primary mb-3">
                          <div class="card-header">
                            <p>Gestionar Priodo Contable</p>
                          </div>
                      </div>
                      <div class="card-body" class="card-body text-secondary">
                          <a>
                            <img class = "card-img-top" src="{{asset('imagenes/priodoContable.webp')}}" alt="" class="img-fluid">
                          </a>
                      </div>
                  
              </div>
         </div>

         <div class="col-lg-3" class="card border-secondary mb-3">
              <div class="card" style="height: 20rem;">
                      <div class= "card" class="card border-primary mb-3">
                          <div class="card-header">
                            <p>Cuentas de Ratios</p>
                          </div>
                      </div>
                      <div class="card-body" class="card-body text-secondary">
                          <a>
                            <img class = "card-img-top" src="{{asset('imagenes/cuentasRatios.png')}}" alt="" class="img-fluid">
                          </a>
                      </div>
                  
              </div>
         </div>

         <div class="col-lg-3" class="card border-secondary mb-3">
              <div class="card" style="height: 20rem;">
                      <div class= "card" class="card border-primary mb-3">
                          <div class="card-header">
                            <p>Grafico de Cuentas</p>
                          </div>
                      </div>
                      <div class="card-body" class="card-body text-secondary">
                          <a>
                            <img class = "card-img-top" src="{{asset('imagenes/grafico.jpg')}}" alt="" class="img-fluid">
                          </a>
                      </div>
                  
              </div>
         </div>

         <div class="col-lg-3" class="card border-secondary mb-3">
              <div class="card" style="height: 22rem;">
                      <div class= "card" class="card border-primary mb-3">
                          <div class="card-header">
                            <p>Analisis Horizontal</p>
                          </div>
                      </div>
                      <div class="card-body" class="card-body text-secondary">
                          <a>
                            <img class = "card-img-top" src="{{asset('imagenes/analisisHorizontal.webp')}}" alt="" class="img-fluid">
                          </a>
                      </div>
                  
              </div>
         </div>

         <div class="col-lg-3" class="card border-secondary mb-3">
              <div class="card" style="height: 22rem;">
                      <div class= "card" class="card border-primary mb-3">
                          <div class="card-header">
                            <p>Analisis Vertical</p>
                          </div>
                      </div>
                      <div class="card-body" class="card-body text-secondary">
                          <a>
                            <img class = "card-img-top" src="{{asset('imagenes/analisisHorizontal.webp')}}" alt="" class="img-fluid">
                          </a>
                      </div>
                  
              </div>
         </div>

    </div>
    <br>
    <br>
    <br>
    </form>
</body>
</html>