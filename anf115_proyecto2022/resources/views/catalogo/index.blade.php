@extends('layouts.app')

@section('template_title')
    Catalogo
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Catalogo') }}
                            </span>

                             <div class="float-right">
                             
                                <a href="{{ route('catalogos.create',$idEmpresa) }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}

                                </a>
                               
                              </div>
                        </div>
                    </div>
                    <!--@if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    @if ($message = Session::get('warning'))
                        <div class="alert alert-warning">
                            <p>{{ $message }}</p>
                        </div>
                    @endif-->

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Idempresa</th>
										<th>Codigocuenta</th>
										<th>Nombrecuenta</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($catalogos as $catalogo)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $catalogo->IDEMPRESA }}</td>
											<td>{{ $catalogo->CODIGOCUENTA }}</td>
											<td>{{ $catalogo->NOMBRECUENTA }}</td>

                                            <td>
                                                <form action="{{ route('catalogos.destroy',[$catalogo->IDEMPRESA,$catalogo->CODIGOCUENTA]) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('catalogos.show',[$catalogo->IDEMPRESA,$catalogo->CODIGOCUENTA]) }}"><i class="fa fa-fw fa-eye"></i> Show</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('catalogos.edit',[$catalogo->IDEMPRESA,$catalogo->CODIGOCUENTA]) }}"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $catalogos->links() !!}
            </div>
        </div>
    </div>
@endsection
