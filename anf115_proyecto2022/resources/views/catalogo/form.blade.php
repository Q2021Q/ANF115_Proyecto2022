<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('IDEMPRESA') }}
            {{ Form::text('IDEMPRESA', $catalogo->IDEMPRESA, ['class' => 'form-control', 'readonly' => 'true'. ($errors->has('IDEMPRESA') ? ' is-invalid' : ''), 'placeholder' => 'Idempresa']) }}
            {!! $errors->first('IDEMPRESA', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('CODIGOCUENTA') }}
            {{ Form::text('CODIGOCUENTA', $catalogo->CODIGOCUENTA, ['class' => 'form-control', 'readonly' => 'true'. ($errors->has('CODIGOCUENTA') ? ' is-invalid' : ''), 'placeholder' => 'Codigocuenta']) }}
            {!! $errors->first('CODIGOCUENTA', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('NOMBRECUENTA') }}
            {{ Form::text('NOMBRECUENTA', $catalogo->NOMBRECUENTA, ['class' => 'form-control' . ($errors->has('NOMBRECUENTA') ? ' is-invalid' : ''), 'placeholder' => 'Nombrecuenta']) }}
            {!! $errors->first('NOMBRECUENTA', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>