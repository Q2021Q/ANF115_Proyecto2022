@extends('layouts.app')

@section('template_title')
    @foreach ($catalogo as $object)
        {{ $object->IDEMPRESA ?? 'Show Catalogo' }}
    @endforeach
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Catalogo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('catalogos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        @foreach ($catalogo as $object)
                        <div class="form-group">
                            <strong>Idempresa:</strong>
                           {{ $object->IDEMPRESA }}
                        </div>
                        <div class="form-group">
                            <strong>Codigocuenta:</strong>
                            {{ $object->CODIGOCUENTA }}
                        </div>
                        <div class="form-group">
                            <strong>Nombrecuenta:</strong>
                            {{ $object->NOMBRECUENTA }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
