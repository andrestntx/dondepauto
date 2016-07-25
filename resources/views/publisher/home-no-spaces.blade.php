@extends('layouts.publisher')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')
    <div class="ibox float-e-margins" style="margin-bottom: 0;">
        <div class="ibox-content" style="padding: 30px 0;">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                    <h2 style="margin-bottom:5px;">{{ $publisher->company }}</h2>
                    <h3 class="text-lg">¡Tenemos clientes potenciales para tu medio publicitario!</h3>
                    <a href="{{ route('medios.espacios.create', $publisher) }}" class="btn btn-warning btn-lg btn-xlg btn-effect-ripple" style="margin-top:20px;">EMPEZAR A OFERTAR</a>
                </div>
            </div>  
        </div>          
    </div>

    <div class="col-xs-12 text-center gray-features">
        <h4>¿Por qué presentar tus ofertas en <strong>DóndePauto.Co</strong>?</h4>
        <div class="icons-features">
            <div class="icon-features">
                <img src="/assets/img/icons-features/1.png">
                <p>Publicar ofertas en DóndePauto es muy fácil y rápido</p>
            </div>
            <div class="icon-features">
                <img src="/assets/img/icons-features/2.png">
                <p>Promocionamos tus ofertas en formato de alto impacto visual, accesible desde internet por nuestros anunciantes</p>
            </div>
            <div class="icon-features">
                <img src="/assets/img/icons-features/3.png">
                <p>Amplias tu visibilidad, recordación y alcance comercial</p>
            </div>
            <div class="icon-features">
                <img src="/assets/img/icons-features/4.png">
                <p>Aumentas tus oportunidades con clientes que no trabajan con agencias tradicionales</p>
            </div>
            <div class="icon-features">
                <img src="/assets/img/icons-features/5.png">
                <p>Diversificas tus fuentes de ingresos</p>
            </div>
        </div>
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-content" style="padding: 40px 0;">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                   <h3 class="text-lg-center">Presenta tu inventario de ofertas, valida la información y llega a más anunciantes</h3>
                   <a href="{{ route('medios.espacios.create', $publisher) }}" class="btn btn-lg btn-warning btn-effect-ripple btn-xlg" style="margin-top:20px;">¡ CREAR MI PRIMERA OFERTA !</a>
                </div>
            </div>  
        </div>          
    </div>

    <div class="col-xs-12 text-center" style="margin-top:20px;">
        
        <img src="/assets/img/question.png" style="max-width:70px;">
        <h4 class="text-lg" style="margin-bottom:10px;">¡Quiero conocer <a href="#" target="_blank" class="theme-color" >cómo funciona DóndePauto!</a> </h4>
        <p class="text-lg" style="font-size: 15.3px;"> (modalidades de ventas, oblicaciones de DóndePauto, precios de oferta al público, formas de pagos por tus servicios)</p>
        <div class="col-md-10 col-md-offset-1 sponsors">
            <div style="border: 1px dotted #C7C3C3; max-width: 1000px; display: block; margin: 48px auto 0 auto;"></div>
            <h3>Apoyos recibidos</h3>
            <div class="col-md-3 text-center">
                <img src="/assets/img/acelerated_wayra.png" class="img-responsive" style="width:70%;">
            </div>
            <div class="col-md-3 text-center">
                <img src="http://www.dondepauto.co/images/footerLogos/telefonica.png" class="img-responsive">
            </div>
            <div class="col-md-3 text-center">
                <img src="http://www.dondepauto.co/images/footerLogos/innpulsa.png" class="img-responsive">
            </div>
            <div class="col-md-3 text-center">
                <img src="http://www.dondepauto.co/images/footerLogos/nxtp_Labs.png" class="img-responsive">
            </div>
        </div>   
    </div>
   
@endsection

@section('extra-js')
    <script>
        
    </script>
@endsection