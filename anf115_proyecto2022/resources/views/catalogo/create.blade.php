@extends('layouts.app')

@section('template_title')
    Create Catalogo
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">Create Catalogo</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('catalogos.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            <div class="box box-info padding-1">
                            <div class="box-body">
        
                              
                                <div class="form-group">
                                    {{ Form::label('IDEMPRESA') }}
                                    {{ Form::text('IDEMPRESA', $idEmpresa, ['class' => 'form-control', 'readonly' => 'true'. ($errors->has('IDEMPRESA') ? ' is-invalid' : ''), 'placeholder' => 'Idempresa']) }}
                                    {!! $errors->first('IDEMPRESA', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                                <div class="form-group">
                                    {{ Form::label('CODIGOCUENTA') }}
                                    {{ Form::text('CODIGOCUENTA', $catalogo->CODIGOCUENTA, ['class' => 'form-control' . ($errors->has('CODIGOCUENTA') ? ' is-invalid' : ''), 'placeholder' => 'Codigocuenta']) }}
                                    {!! $errors->first('CODIGOCUENTA', '<div class="invalid-feedback">:message</div>') !!}
                                </div>      
                                <div class="form-group">
                                    {{ Form::label('NOMBRECUENTA') }}
                                    {{ Form::text('NOMBRECUENTA', $catalogo->NOMBRECUENTA, ['class' => 'form-control' . ($errors->has('NOMBRECUENTA') ? ' is-invalid' : ''), 'placeholder' => 'Nombrecuenta']) }}
                                    {!! $errors->first('NOMBRECUENTA', '<div class="invalid-feedback">:message</div>') !!}
                                </div>


                                <div class="box-footer mt20">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
