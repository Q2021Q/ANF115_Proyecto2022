@extends('layouts.app')

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
            <a href="{{route('empresa_insert')}}" class="btn btn-primary">Agregar Empresa</a> -->
        </div>
        </ul>
      </nav>  <!-- /.sidebar-menu -->
    </div>  <!-- /.sidebar -->
</aside>
@endsection

@section('content')
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
                    <div class="card" class="card border-primary mb-3">
                    <div class="card-header text-center">
                    <p class="h6">Cargar Estado de Resultados</p>
                        </div>
                    </div>
                    <div class="card-body" class="card-body text-secondary">
                        <a href="{{route('importar_estado_resultados', $idEmpresa)}}">
                            <img class="card-img-top" src="{{asset('imagenes/estadoResultado.jpg')}}" alt=""
                                class="img-fluid">
                        </a>
                    </div> 
                  </div>
                </div>

                <div class="col-lg-3" class="card border-secondary mb-3">
                    <div class="card" style="height: 20rem;">
                        <div class="card" class="card border-primary mb-3">
                        <div class="card-header text-center">
                        <p class="h6">Cuentas de Estados Financieros</p>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                            <a>
                                <img class="card-img-top" src="{{asset('imagenes/cuentaIMG.png')}}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3" class="card border-secondary mb-3">
                    <div class="card" style="height: 20rem;">
                        <div class="card" class="card border-primary mb-3">
                        <div class="card-header text-center">
                        <p class="h6">Cuentas de Catalogo</p>
                            </div>
                        </div> 
                        <div class="card-body" class="card-body text-secondary">
                            <a href="{{ URL::to('catalogos')}}">
                                <img class="card-img-top" src="{{asset('imagenes/cuentaCatalogo.jpg')}}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3" class="card border-secondary mb-3">
                    <div class="card" style="height: 20rem;">
                        <div class="card" class="card border-primary mb-3">
                        <div class="card-header text-center">
                        <p class="h6">Gestionar Periodo Contable</p>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                            <a>
                                <img class="card-img-top" src="{{asset('imagenes/priodoContable.webp')}}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3" class="card border-secondary mb-3">
                    <div class="card" style="height: 20rem;">
                        <div class="card" class="card border-primary mb-3">
                        <div class="card-header text-center">
                        <p class="h6">Cuentas de Ratios</p>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                            <a href="{{route('actualizarRatioGeneral_Get')}}">
                                <img class="card-img-top" src="{{asset('imagenes/cuentasRatios.png')}}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3" class="card border-secondary mb-3">
                    <div class="card" style="height: 20rem;">
                        <div class="card" class="card border-primary mb-3">
                        <div class="card-header text-center">
                        <p class="h6">Grafico de Cuentas</p>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                        <a href="{{route('graficas_C', $idEmpresa)}}">
                                <img class="card-img-top" src="{{asset('imagenes/grafico.jpg')}}" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3" class="card border-secondary mb-3">
                    <div class="card" style="height: 22rem;">
                        <div class="card" class="card border-primary mb-3">
                        <div class="card-header text-center">
                        <p class="h6">Analisis Horizontal</p>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                            <a href="{{route('analisisHorizontal_Get', $idEmpresa)}}">
                                <img class="card-img-top" src="{{asset('imagenes/analisisHorizontal.webp')}}" alt=""
                                    class="img-circle img-fluid">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3" class="card border-secondary mb-3">
                    <div class="card" style="height: 22rem;">
                        <div class="card" class="card border-primary mb-3">
                            <div class="card-header text-center">
                            <p class="h6">Analisis Vertical</p>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                            <a href="{{route('analisisVerticall_Get', $idEmpresa)}}">
                                <img class="card-img-top" src="{{asset('imagenes/analisisHorizontal.webp')}}" alt=""
                                    class="img-rounded img-fluid">
                                    
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3" class="card border-secondary mb-3">
                    <div class="card" style="height: 22rem;">
                        <div class="card" class="card border-primary mb-3">
                            <div class="card-header text-center">
                            <p class="h6">Comparacion por ratios generales</p>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                            <a href="{{route('comparacionRatio_General', $idEmpresa)}}">
                                <img class="card-img-top" src="{{asset('imagenes/ratioGeneral.jpg')}}" alt=""
                                    class="img-rounded img-fluid">
                                    
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3" class="card border-secondary mb-3">
                    <div class="card" style="height: 22rem;">
                        <div class="card" class="card border-primary mb-3">
                            <div class="card-header text-center">
                            <p class="h6">Comparacion de ratios en dos periodos </p>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                            <a href="{{route('comparacionRatio_periodoAperidoB', $idEmpresa)}}">
                                <img class="card-img-top" src="{{asset('imagenes/periodoAB.jpg')}}" alt=""
                                    class="img-rounded img-fluid">
                                    
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3" class="card border-secondary mb-3">
                    <div class="card" style="height: 22rem;">
                        <div class="card" class="card border-primary mb-3">
                            <div class="card-header text-center">
                            <p class="h6">Promedio Empresarial </p>
                            </div>
                        </div>
                        <div class="card-body" class="card-body text-secondary">
                            <a href="{{route('comparacionRatioPromedioEmpresarialRedi_get', $idEmpresa)}}">
                                <img class="card-img-top" src="{{asset('imagenes/promedioEmpresa.jpg')}}" alt=""
                                    class="img-rounded img-fluid">
                                    
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            <br>
            <br>
            <br>
</form>
@endsection