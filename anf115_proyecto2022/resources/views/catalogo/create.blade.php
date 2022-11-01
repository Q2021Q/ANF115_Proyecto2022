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
                                    {!! Form::label('$catalogo->IDEMPRESA',"Empresas") !!}
                                    {!! Form::select('IDEMPRESA',$empresas,null, ['class' => 'form-control']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('$catalogo->CODIGOCUENTA',"Codigo Cuenta") !!}
                                    {!! Form::select('CODIGOCUENTA',$cuentas,null, ['class' => 'form-control']) !!}
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
