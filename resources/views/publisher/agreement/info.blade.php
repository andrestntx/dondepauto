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
            <h2>Activa y valida tu medio publicitario</h2>
        </div>

        <div class="col-xs-8 col-xs-offset-2" id="icons">
            <div class="line hidden-xs hidden-sm">
                
            </div>
            <div class="figures">
                <figure class="col-sm-4">
                    <img src="/assets/icons/aggrement/icono1gris.png">
                    <p><i class="fa fa-check"></i> Completaste tus datos</p>
                </figure>
                <figure class="col-sm-4">
                    <img src="/assets/icons/aggrement/icono2gris.png">
                    <p><i class="fa fa-check"></i> Publicaste tus ofertas</p>
                </figure>
                <figure class="col-sm-4">
                    <img src="/assets/icons/aggrement/icono3azul.png">
                    <p><strong>Formaliza el acuerdo de servicios y da de alta tus ofertas</strong></p>
                </figure>
            </div>
        </div>

        <div class="col-xs-12 text-center" style="margin-bottom:30px;">
            <a href="{{ route('medios.agreement.complete', $publisher) }}" class="btn btn-lg btn-warning btn-effect-ripple btn-xlg">
                ACTIVAR OFERTAS
            </a> 
        </div>

    </div>    
   
@endsection

@section('extra-js')
    <script>
        
    </script>
@endsection