@extends('layouts.publisher')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="/assets/css/publisher/dashboard.css" />
    <link href="/assets/css/plugins/slick/slick.css" rel="stylesheet">
    <link href="/assets/css/plugins/slick/slick-theme.css" rel="stylesheet">
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')
    <div class="dashboard">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 slide-tips">
            <h2 class="text-center m">
                ¿Por qué validamos a los Medios Publicitarios que presentamos a los anunciantes?
            </h2>
            <h3 class="text-center m">
                DóndePatuo busca generar confianza entre las marcas anunciantes que compran a través de su plataforma de servicio. Para esto verificamos:
            </h3>
        </div>

        <div class="col-xs-12 col-sm-10 col-sm-offset-1 slide-tips">
            <div class="ibox float-e-margins">
                <div class="ibox-content ibox-content-margin">
                    <div class="row slide-tips-content">
                        <div class="col-lg-10 col-lg-offset-1">
                            <div class="ibox">
                                <div class="slick-tips">
                                    <div>
                                        <div class="ibox-content">
                                            <p>
                                                Que los Medios Publicitarios tienen capacidad legal para comercializar sus espacios de pauta en Colombia.
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ibox-content">
                                            <p>
                                                Que las personas que se registran a nombre de un Medio Publicitario se encuentran autorizados por dicho medio publicitario para formular ofertas a través de DóndePauto.
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ibox-content">
                                            <p>
                                                Que la cuenta bancaria a donde se transferirán los pagos se encuentra activa y suscrita a nombre del Medio Publicitario.
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="ibox-content">
                                            <p>
                                                Que se aceptan los términos y condiciones referentes a formas de pagos al Medio y el incentivo de comisión para DóndePauto, entre otros.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   

        <div class="col-xs-12 agreement-form">
            <div class="col-sm-2">
                <img src="/assets/img/agreement/icono2.png" class="icon-steps">
                <div class="horizontal-line">
                </div>
            </div>

            <div class="col-sm-8">
                <h2>Carta de aceptación de términos de la plataforma</h2>
                <p class="intro-form">Para generar el borrador de la carta de aceptación y de incentivo económico, que deberá ser firmada por el representante legal del medio publicitario y enviada en original a las oficinas de DóndePauto, por favor registrar la información exacta de su empresa y de su Representante Legal.</p>

                {!! Form::open([]) !!}
                    <div class="col-xs-12">
                        <div class="ibox float-e-margins ibox-content-margin">
                            <div class="ibox-title">
                                <h3 class="text-title">
                                    Formulario de Datos del Medio Publicitario y Representante Legal
                                </h3>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-6"> 
                                        {!! Field::text('company') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('first_name') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('last_name') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('email') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('phone') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('cel') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('company_nit') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('company_nit') !!} 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-xs-12 btn-save-agreement">
                        <img src="/assets/img/agreement/download.png">
                    </div>

                    <div class="col-md-12" style="padding-left: 35px; padding-top: 10px;">
                        <div class="checkbox m-r-xs">
                            {!! Form::checkbox('signed_agreement', 1, 0, ['id' => 'signed_agreement']) !!}
                            <label for="signed_agreements">
                                Acepto 
                            </label>
                            <span style="font-size: 1.15em; font-weight: 600;">los <a href="#" style="color: #2cbaf8;">términos y condiciones</a> del acuerdo servicio</span>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>

        <div class="col-xs-12 agreement-form">
            <div class="col-sm-2">
                <img src="/assets/img/agreement/icono1.png" class="icon-steps">
                <div class="horizontal-line">
                </div>
            </div>

            <div class="col-sm-8">
                <h2>Documentos para validación de medio Publicitario</h2>
                <p class="intro-form">Para validar la existencia y representación legal de <strong>{{ $publisher->company }}</strong> por favor subir la siguiente documento en formato PDF</p>

                {!! Form::open([]) !!}
                    <div class="col-xs-12">
                        <div class="ibox float-e-margins ibox-content-margin">
                            <div class="ibox-title">
                                <h3 class="text-title">
                                    Documentos para validación de medio Publicitario
                                </h3>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-md-6"> 
                                        {!! Field::text('company') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('first_name') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('last_name') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('email') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('phone') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('cel') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('company_nit') !!} 
                                    </div>
                                    <div class="col-md-6"> 
                                        {!! Field::text('company_nit') !!} 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-xs-12 btn-save-agreement">
                        <img src="/assets/img/agreement/download.png">
                    </div>

                    <div class="col-md-12" style="padding-left: 35px; padding-top: 10px;">
                        <div class="checkbox m-r-xs">
                            {!! Form::checkbox('signed_agreement', 1, 0, ['id' => 'signed_agreement']) !!}
                            <label for="signed_agreements">
                                Acepto 
                            </label>
                            <span style="font-size: 1.15em; font-weight: 600;">los <a href="#" style="color: #2cbaf8;">términos y condiciones</a> del acuerdo servicio</span>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>    
   
@endsection

@section('extra-js')
    <!-- slick carousel-->
    <script src="/assets/js/plugins/slick/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.slick-tips').slick({
                dots: true
            });
        });
    </script>
@endsection