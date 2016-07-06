@extends('layouts.publisher')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="/assets/css/publisher/dashboard.css" />
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')
    <div class="dashboard">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <h1>{{ $publisher->company }}</h1>
                    </div>
                </div>  
            </div>          
        </div>

        <div class="col-xs-12 text-center sub-title">
            <h2>¡Tus ofertas se encuentran activas! Te invitamos a que ofertes nuevos productos y aumentes tus posibilidades de ventas</h2>
        </div>

        <div class="col-xs-12 content">
            <h1>Mi inventario de Medios</h1>

            <div class="text-center">
                <a href="{{ route('medios.espacios.create', $publisher) }}" class="btn btn-lg btn-warning btn-effect-ripple btn-xlg">
                    <i class="fa fa-plus-circle"></i> CREAR NUEVA OFERTA
                </a>    
                <a href="{{ route('medios.espacios.index', $publisher) }}" class="btn btn-lg btn-info btn-effect-ripple btn-xlg">
                    <i class="fa fa-search"></i> VER MI INVENTARIO
                </a>    
            </div>
            
        </div>
    </div>    
   
@endsection

@section('extra-js')
    <script>
        
    </script>
@endsection