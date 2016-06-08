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
                    <a href="#" class="btn btn-lg btn-xlg btn-effect-ripple" style="margin-top:20px;">EMPEZAR A OFERTAR</a>
                </div>
            </div>  
        </div>          
    </div>

    <div class="col-xs-12 text-center gray-features">
        <h4>¿Por qué publicar tus ofertas en <strong>DóndePauto.Co</strong>?</h4>
        <div class="icons-features">
            <div class="icon-features">
                <img src="/assets/img/icons-features/1.png">
                <p>Publicar tus ofertas es muy fácil y gratis</p>
            </div>
            <div class="icon-features">
                <img src="/assets/img/icons-features/2.png">
                <p>Obtienes mayor visibilidad, alcance comercial y la posibilidad de mayores ventas recurrentes</p>
            </div>
            <div class="icon-features">
                <img src="/assets/img/icons-features/3.png">
                <p><strong>DóndePauto</strong> se encarga de promocionar y vender tus espacios de pauta</p>
            </div>
            <div class="icon-features">
                <img src="/assets/img/icons-features/4.png">
                <p>Solo pagas por ventas efectivas!. Tu estables la comisión</p>
            </div>
            <div class="icon-features">
                <img src="/assets/img/icons-features/5.png">
                <p>Amplias tus oportunidades de negocios con anunciantes que no están con las tradicionales agencias de medios</p>
            </div>
        </div>
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-content" style="padding: 40px 0;">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 text-center">
                   <h3 class="text-lg-center">Publica tu inventario de ofertas, <span class="theme-color">activa el servicio</span> y comienza a vender</h3>
                   <a href="#" class="btn btn-lg btn-effect-ripple btn-xlg" style="margin-top:20px;">¡ PUBLICA TU PRIMERA OFERTA !</a>
                </div>
            </div>  
        </div>          
    </div>

    <div class="col-xs-12 text-center" style="margin-top:20px;">
        
        <img src="/assets/img/question.png" style="max-width:70px;">
        <h4 class="text-lg">¡Quiero conocer cómo funciona el <a href="#" target="_blank" class="theme-color">servicio de DóndePauto!</a> </h4>
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