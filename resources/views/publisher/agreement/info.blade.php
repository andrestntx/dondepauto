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

        <div class="col-xs-12 text-center sub-title sub-title-lg">
            <h2>
                @if(! $publisher->has_offers && ! $publisher->has_signed_agreement)
                    Sólo estás a dos pasos para activarte como proveedor
                @elseif($publisher->has_offers || $publisher->has_signed_agreement)
                    Sólo estás a un paso para activarte como proveedor
                @else
                    Felicitaciones 
                @endif
            </h2>
        </div>

        <div class="col-xs-8 col-xs-offset-2 agreement-info" id="icons">
            @include('publisher.steps')
        </div>

        <div class="col-md-10 col-md-offset-1 text-center" style="margin-top: 20px; border-top: 2px dashed rgba(128, 128, 128, 0.42); padding-top: 20px; padding-bottom: 30px;">
            <img src="/assets/img/question.png" style="max-width:70px;">
            <h4 class="text-lg" style="margin-bottom:10px;">¡Quiero conocer <a href="http://www.dondepauto.co/modelo-de-negocio-medios-publicitarios" target="_blank" class="theme-color" >cómo funciona DóndePauto!</a> </h4>
            <p class="text-lg" style="font-size: 15.3px;"> (modalidades de ventas, oblicaciones de DóndePauto, precios de oferta al público, formas de pagos por tus servicios)</p>
        </div>

    </div>    
   
@endsection

@section('extra-js')
    <script>
        
    </script>
@endsection