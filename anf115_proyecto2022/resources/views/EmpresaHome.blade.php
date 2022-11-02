@extends('layouts.app')

@section('menu')

        <div>
            <a href="{{route('empresa_insert')}}" class="btn btn-primary">Agregar Empresa</a>
        </div>



@endsection

@section('content')

    <div class="col-lg-12" style="padding-top: 20px;">
        <div class="card">
            <div class="card-header">
                Empresas
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xs-4">
            
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="container mt-5">
                <div class="row">
                    @foreach($listEmpresa as $empresa)
                    <div class="col-lg-4" class="card border-secondary mb-3">
                        <div class="card" style="height: 25rem;">
                            <div class="card" class="card border-primary mb-3">
                                <div class="card-header">
                                    {{$empresa->NOMBREEMPRESA}}
                                </div>
                            </div>
                            <div class="card-body" class="card-body text-secondary">
                                <a href="{{route('EmpresaGestion', $empresa->IDEMPRESA)}}">
                                    <img class="card-img-top" src="{{asset($empresa->NOMBREFOTOEMPRESA)}}" alt=""
                                        class="img-fluid">
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>
@endsection