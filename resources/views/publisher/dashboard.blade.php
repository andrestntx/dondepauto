@extends('layouts.publisher')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="/assets/css/publisher/dashboard.css" />
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')
    <div class="dashboard">
        <div class="ibox float-e-margins publihser-name">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <h1>{{ $publisher->company }}</h1>
                    </div>
                </div>  
            </div>          
        </div>

        <div class="col-xs-8 col-xs-offset-2 short" id="icons">
            <div class="line hidden-xs hidden-sm">
                
            </div>
            <div class="figures">
                <figure class="col-sm-4">
                    @if($publisher->complete_data)
                        <img src="/assets/icons/aggrement/icono1gris.png">
                        <p><i class="fa fa-check"></i> Completaste tus datos</p>
                    @else
                        <img src="/assets/icons/aggrement/icono1azul.png">
                        <p><i class="fa fa-check"></i> Completa tus datos</p>
                    @endif
                </figure>
                <figure class="col-sm-4">
                    @if($publisher->count_spaces > 0)
                        <img src="/assets/icons/aggrement/icono2gris.png">
                        <p><i class="fa fa-check"></i> Publicaste tus ofertas</p>
                    @else
                        <img src="/assets/icons/aggrement/icono2azul.png">
                        <p><strong><i class="fa fa-check"></i> Publica tus ofertas</p></strong>
                    @endif
                </figure>
                <figure class="col-sm-4">
                    @if($publisher->has_signed_agreement)
                        <img src="/assets/icons/aggrement/icono3gris.png">
                        <p>Formalizaste el acuerdo de servicios y tus ofertas están activas</p>
                    @else
                        <img src="/assets/icons/aggrement/icono3azul.png">
                        <p><strong>Formaliza el acuerdo de servicios y da de alta tus ofertas</strong></p>
                    @endif
                    
                </figure>
            </div>
        </div>

        <hr class="separator-dashbaord col-xs-12">

        <div class="col-xs-12 cols-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

            <div class="row">
                <div class="col-sm-6">
                    <div class="ibox ibox-dashboard float-e-margins">
                        <div class="ibox-title ibox-title-green">
                        </div>
                        <div class="ibox-content" style="display: block;">
                            <h2>Mis ofertas en DóndePauto</h2>
                            <hr>
                            <div class="row inventary-detail">
                                <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2" id="pointsInventary">
                                    <p id="title-point">Puntaje</p>
                                    <div class="pieProgress" role="progressbar" data-goal="100" aria-valuemin="0" data-step="2" aria-valuemax="100">
                                        <div class="pie_progress__number">0</div>
                                    </div>
                                    <a id="help-modal-point" data-toggle="modal" data-target="#modalPointsInventary">¿Cómo mejorar la calificación?</a>

                                    <div class="modal inmodal" id="modalPointsInventary" tabindex="-1" role="dialog"  aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content animated fadeIn">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                                                    <img src="/assets/img/dashboard/iconmodal.png" class="icon-modal">
                                                    <h4 class="modal-title">Consejos para crear ofertas con mayor potencial de ventas!</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>El Puntaje califica que tan completa, precisa, y clara es la información registrada en la oferta, lo que aporta mayor valor, rapidez y seguridad a los Anunciantes en la toma de decisiones de compra. 
                                                    </p>
                                                    <p>Ofertas con mayores puntajes tienen mejor exposición en la Plataforma y captan mayor interés.</p>
                                                    <p class="tip-extra">Mejora tu puntaje siguiendo los consejos en el formulario de publicación de ofertas haciendo click en "Activar Ayuda"</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr class="col-xs-9 col-xs-offset-1">
                                <div class="col-xs-12">
                                    <h1> <img src="/assets/img/dashboard/iconototalof.png" class="img-icon"> Total de ofertas</h1>
                                    <h2>{{ $publisher->spaces->count() }}</h2>
                                </div>
                                <hr class="col-xs-9 col-xs-offset-1">
                                <div class="col-xs-12">
                                    <h1> <img src="/assets/img/dashboard/iconovalorport.png" class="img-icon">  Valor de portafolio</h1>
                                    <h2 id="price-inventary">${{ number_format($publisher->spaces->sum('minimal_price'), 0, ',', '.') }}</h2>
                                </div>
                            </div>

                        </div>
                        <div class="ibox-footer">
                            <div class="row text-center">
                                <div class="col-sm-6">                                                           
                                    <a href="{{ route('medios.espacios.create', $publisher) }}" class="btn btn-lg btn-warning btn-effect-ripple btn-sm btn-block">
                                        <i class="fa fa-plus-circle"></i> CREAR NUEVA OFERTA
                                    </a>    
                                </div>
                                <div class="col-sm-6">    
                                    <a href="{{ route('medios.espacios.index', $publisher) }}" class="btn btn-lg btn-info btn-effect-ripple btn-sm btn-block">
                                        <i class="fa fa-search"></i> VER MI INVENTARIO
                                    </a> 
                                </div>   
                            </div>
                        </div>
                    </div>
                    <div class="box-message">
                        <div class="icon-message">
                            <img src="/assets/img/dashboard/diamantegris.png" class="img-icon">
                        </div>
                        <h3>¡Tus ofertas se encuentran activas!</h3>
                        <p>Te invitamos a que ofertes nuevos productos y 
                        que aumentes tus posibilidades de ventas</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="ibox ibox-dashboard float-e-margins">
                        <div class="ibox-title">
                        </div>
                        <div class="ibox-content" style="display: block;">
                            <h2>Acuerdo de incentivos</h2>
                            <hr>
                            <div class="row agreement-detail">
                                <div class="col-xs-12">
                                    <div class="agreement-icon">
                                        <img src="/assets/img/dashboard/iconocomision.png" class="img-icon">
                                    </div>
                                    <div class="agreement-text">
                                        <h1>15%</h1>
                                        <h2>Incentivo Comisión DóndePauto</h2>
                                    </div>
                                </div>
                                <hr class="col-xs-9 col-xs-offset-1">
                                <div class="col-xs-12">
                                    <div class="agreement-icon">
                                        <img src="/assets/img/dashboard/iconodectpronto.png" class="img-icon">
                                    </div>
                                    <div class="agreement-text">
                                        <h1>15%</h1>
                                        <h2>Descuento por Pronto Pago</h2>
                                    </div>
                                </div>
                                <hr class="col-xs-9 col-xs-offset-1">
                                <div class="col-xs-12">
                                    <div class="agreement-icon">
                                        <img src="/assets/img/dashboard/iconobanco.png" class="img-icon">
                                    </div>
                                    <div class="agreement-text">
                                        <h1>15%</h1>
                                        <h2>Banco</h2>
                                    </div>
                                </div>
                                <hr class="col-xs-9 col-xs-offset-1">
                                <div class="col-xs-12">
                                    <div class="agreement-icon">
                                        <img src="/assets/img/dashboard/iconocuenta.png" class="img-icon">
                                    </div>
                                    <div class="agreement-text">
                                        <h1>15%</h1>
                                        <h2>Número de Cuenta Bancaria</h2>
                                    </div>
                                </div>
                                <hr class="col-xs-9 col-xs-offset-1">
                                <div class="col-xs-12">
                                    <div class="agreement-icon">
                                        <img src="/assets/img/dashboard/iconoretencion.png" class="img-icon">
                                    </div>
                                    <div class="agreement-text">
                                        <h1>15%</h1>
                                        <h2>Retención Aplicable</h2>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="ibox-footer">
                            <div class="row text-center">
                                <div class="col-sm-12">    
                                    <a href="{{ route('medios.espacios.index', $publisher) }}" class="btn btn-lg btn-info btn-effect-ripple btn-sm">
                                        <i class="fa fa-pencil"></i> SOLICITAR CAMBIO DE INFORMACIÓN
                                    </a> 
                                </div>   
                            </div>
                        </div>
                    </div>
                    <div class="box-message">
                        <div class="icon-message">
                            <img src="/assets/img/dashboard/diamantegris.png" class="img-icon">
                        </div>
                        <h3>¡Tus ofertas se encuentran activas!</h3>
                        <p>Te invitamos a que ofertes nuevos productos y 
                        que aumentes tus posibilidades de ventas</p>
                    </div>
                </div>
            </div>
            <hr class="hr-pencil">

            <div class="row comercial-detail">
                <div class="col-sm-12">
                    <h1>Datos Comerciales</h1>
                    <div class="col-md-7">
                        <div class="col-xs-12">
                           <h2>Datos del Contacto Comercial <span></span></h2> 
                        </div>
                        
                        <div class="col-sm-6">
                           <p><strong>Nombre:</strong> </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Cargo:</strong> </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Teléfono:</strong> </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Email:</strong> </p> 
                        </div>
                        

                        <div style="text-align:center;" class="col-xs-12">
                            <h2>Datos de la empresa <span></span></h2>
                        </div>

                        <div class="col-sm-6">
                           <p><strong>Rep. Legal:</strong> </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Ranzón Social:</strong> </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>NIT:</strong> </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Cédula:</strong> </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Teléfono:</strong> </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Email:</strong> </p> 
                        </div>

                    </div>
                    <div class="col-md-5">
                        <h2>Doc. de Validación de Cuenta <span></span></h2>
                    </div>
                </div>
            </div>

        </div>
    </div>    
   
@endsection

@section('extra-js')
    <script>
        $(".pieProgress").asPieProgress({
            namespace: 'pieProgress',
            barsize: 18,
            barcolor: "#01aeef",
            min: 0,
            max: 100,
            goal: 100,
            step: 1,
            speed: 50, // refresh speed
            delay: 300,
            easing: 'ease',
            label: function(n) {
                return n;
            },
            numberCallback: function(n){
                if(n >= 1){
                    return parseInt(n);
                }
                
                return 0;
            }
        });

        $(document).ready(function(){
            $('.pieProgress').asPieProgress('go', 20);
        });
    </script>
@endsection