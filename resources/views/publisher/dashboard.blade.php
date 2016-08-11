@extends('layouts.publisher')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="/assets/css/publisher/dashboard.css" />
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')
    <div class="se-pre-con"></div>
    <div class="dashboard">
        <div class="ibox float-e-margins publihser-name">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <h1 id="avgPoints" data-points="{{ $publisher->avg_points }}">{{ $publisher->company }}</h1>
                    </div>
                </div>  
            </div>          
        </div>

        <div class="col-xs-8 col-xs-offset-2 short" id="icons">
            <div class="line hidden-xs hidden-sm">
                
            </div>
            @include('publisher.steps')
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
                                    <a href="{{ route('medios.espacios.first-create', $publisher) }}" class="btn btn-lg btn-warning btn-effect-ripple btn-sm btn-block">
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
                                        <h1>{{ $publisher->commission_rate }}%</h1>
                                        <h2>Incentivo Comisión DóndePauto</h2>
                                    </div>
                                </div>
                                <hr class="col-xs-9 col-xs-offset-1">
                                <div class="col-xs-12">
                                    <div class="agreement-icon">
                                        <img src="/assets/img/dashboard/iconodectpronto.png" class="img-icon">
                                    </div>
                                    <div class="agreement-text">
                                        <h1>{{ $publisher->discount }}%</h1>
                                        <h2>Descuento por Pronto Pago</h2>
                                    </div>
                                </div>
                                <hr class="col-xs-9 col-xs-offset-1">
                                <div class="col-xs-12">
                                    <div class="agreement-icon">
                                        <img src="/assets/img/dashboard/iconobanco.png" class="img-icon">
                                    </div>
                                    <div class="agreement-text">
                                        <h1>{{ $publisher->bank_name }}</h1>
                                        <h2>Banco</h2>
                                    </div>
                                </div>
                                <hr class="col-xs-9 col-xs-offset-1">
                                <div class="col-xs-12">
                                    <div class="agreement-icon">
                                        <img src="/assets/img/dashboard/iconocuenta.png" class="img-icon">
                                    </div>
                                    <div class="agreement-text">
                                        <h1>{{ $publisher->bank_account_number }}</h1>
                                        <h2>Número de Cuenta Bancaria</h2>
                                    </div>
                                </div>
                                <hr class="col-xs-9 col-xs-offset-1">
                                <div class="col-xs-12">
                                    <div class="agreement-icon">
                                        <img src="/assets/img/dashboard/iconoretencion.png" class="img-icon">
                                    </div>
                                    <div class="agreement-text">
                                        <h1>{{ $publisher->retention }}% </h1>
                                        <h2>Retención Aplicable</h2>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="ibox-footer">
                            <div class="row text-center">
                                <div class="col-sm-12">  
                                    @if($publisher->has_signed_agreement || $publisher->in_verification) 
                                        <button type="button" class="btn btn-info btn-lg btn-effect-ripple " data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-pencil"></i> 
                                            SOLICITAR CAMBIO DE INFORMACIÓN
                                        </button>
                                    @else
                                        <a href="{{ route('medios.agreement.complete', $publisher) }}" class="btn btn-lg btn-info btn-effect-ripple btn-sm">
                                            <i class="fa fa-pencil"></i> 
                                            ACTIVAR MEDIO PUBLICITARIO
                                        </a> 
                                    @endif
                                </div>   
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div {!! Html::classes(['box-message-danger' => ! $publisher->has_offers, 'box-message-danger' => $publisher->expired_offers, 'box-message-warning' => ( (!$publisher->has_signed_agreement && !$publisher->expired_offers) || !$publisher->has_offers) , 'box-message']) !!}>
                            <div class="icon-message">
                                @if(! $publisher->has_offers || ! $publisher->has_signed_agreement)
                                    <img src="/assets/img/dashboard/alertagris.png" class="img-icon">
                                @else
                                    <img src="/assets/img/dashboard/diamantegris.png" class="img-icon">
                                @endif
                            </div>
                            @if($publisher->has_offers)
                                @if($publisher->has_signed_agreement)
                                    <h3>¡Tus ofertas se encuentran activas!</h3>
                                    <p>Te invitamos a que ofertes nuevos productos y 
                                    que aumentes tus posibilidades de ventas</p>
                                @elseif($publisher->expired_offers)
                                    <h3>¡Tu Medio Publicitario NO ha sido activado como Proveedor!</h3>
                                    <p>Tus ofertas ya no será presentadas a nuestros clientes.
                                    Formaliza tu vinculación radicando la carta de <strong>aceptación e incentivos</strong></p>
                                @else
                                    <h3>¡Tu Medio Publicitario NO ha sido activado como Proveedor!</h3>
                                    <p>Tus ofertas estarán activas por <strong>{{ $publisher->expired_offers_days }} días</strong> en la Plataforma.
                                    Formaliza tu vinculación radicando la carta de <strong>aceptación e incentivos</strong></p>
                                @endif
                            @else
                                <h3>¡NO has presentado Ofertas de Espacios publicitarios!</h3>
                                <p>
                                    Tenemos potenciales clientes para tu medio publicitario.
                                    Presenta tu inventario de ofertas haciendo clic en 
                                    <a href="{{ route('medios.espacios.first-create', $publisher)}}" title="Crear mi primera oferta">
                                        Crear Oferta
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div {!! Html::classes(['box-message-danger' => ! $publisher->has_signed_agreement, 'box-message-warning' => $publisher->in_verification, 'box-message-info' => $publisher->has_signed_agreement, 'box-message']) !!}>
                            <div class="icon-message">
                                @if($publisher->has_signed_agreement) 
                                    <img src="/assets/img/dashboard/iconoestrella.png" class="img-icon">
                                @else
                                    <img src="/assets/img/dashboard/alertagris.png" class="img-icon">
                                @endif
                            </div>
                            @if($publisher->has_signed_agreement)
                                <h3>¡Tu Medio Publicitario se encuentra activo como Proveedor!</h3>
                                <p>Tus ofertas de Espacios Publicitarios disponibles para la venta podrán
                                ser presentado a clientes anunciantes interesados</p>
                            @elseif($publisher->in_verification)
                                <h3>¡La documentación se encuentra en verificación!</h3>
                                <p>
                                    Una vez se valide, DóndePauto te activará como Proveedor
                                    y tus Espacios Publicitarios podrán ser presentados a clientes interesados.
                                </p>
                            @else
                                <h3>¡Tu medio publicitario no ha sido validado como proveedor!</h3>
                                <p>
                                    Activa y valida tu medio publicitario formalizando la carta de 
                                    aceptación e inventivos que deberá ser firmada por tu Representante Legal.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
            <hr class="hr-pencil">

            <div class="row comercial-detail">
                <div class="col-sm-12">
                    <h1>Datos Comerciales</h1>
                    <div class="col-md-7">
                        <div class="col-xs-12 list-point list-point-red">
                           <h2>Datos del Contacto Comercial <span></span></h2> 
                        </div>
                        
                        <div class="col-sm-6">
                           <p><strong>Nombre: </strong> {{ $publisher->name }} </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Cargo: </strong> {{ $publisher->company_role }} </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Teléfono: </strong> {{ $publisher->phone }} </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Email: </strong> {{ $publisher->email }} </p> 
                        </div>
                        

                        <div class="col-xs-12 list-point list-point-orange">
                            <h2>Datos de la empresa <span></span></h2>
                        </div>

                        <div class="col-sm-6">
                           <p><strong>Rep. Legal:</strong> {{ $publisher->representative_name }}</p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Ranzón Social:</strong> {{ $publisher->company_legal }} </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>NIT:</strong> {{ $publisher->company_nit }}</p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Cédula:</strong> {{ $publisher->representative_doc }}</p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Teléfono:</strong> {{ $publisher->representative_phone }} </p> 
                        </div>
                        <div class="col-sm-6">
                           <p><strong>Email:</strong> {{ $publisher->representative_email }} </p> 
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="ibox ibox-dashboard float-e-margins">
                            <div class="ibox-content" style="display: block;">
                                <h2>Doc. de Validación de Cuenta</h2>
                                <hr>
                                @if($publisher->has_signed_agreement)
                                    <a href="{{ $publisher->getDocument('commerce') }}" target="_blank" class="comercial-file"> <img src="/assets/img/dashboard/iconopdfgris.png" class="img-icon"> camara de comercio</a>
                                    <a href="{{ $publisher->getDocument('rut') }}" target="_blank" class="comercial-file"> <img src="/assets/img/dashboard/iconopdfgris.png" class="img-icon"> rut</a>
                                    <a href="{{ $publisher->getDocument('bank') }}" target="_blank" class="comercial-file"> <img src="/assets/img/dashboard/iconopdfgris.png" class="img-icon"> certificación bancaria</a>
                                    <a href="{{ $publisher->getDocument('letter') }}" target="_blank" class="comercial-file"> <img src="/assets/img/dashboard/iconopdfgris.png" class="img-icon"> carta de validación</a>
                                @else
                                    <div class="error-files">
                                        <a href="javascript:void(0);" class="comercial-file"> <img src="/assets/img/dashboard/iconopdfgris.png" class="img-icon"> camara de comercio</a>
                                        <a href="javascript:void(0);" class="comercial-file"> <img src="/assets/img/dashboard/iconopdfgris.png" class="img-icon"> rut</a>
                                        <a href="javascript:void(0);" class="comercial-file"> <img src="/assets/img/dashboard/iconopdfgris.png" class="img-icon"> certificación bancaria</a>
                                        <a href="javascript:void(0);" class="comercial-file"> <img src="/assets/img/dashboard/iconopdfgris.png" class="img-icon"> carta de validación</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @can('changeAgreement', $publisher)
                        <div class="col-sm-12 text-center">
                            <button type="button" class="btn btn-info btn-lg btn-effect-ripple " data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-pencil"></i> 
                                SOLICITAR CAMBIO DE INFORMACIÓN
                            </button>
                        </div>
                    @endcan
                </div>
            </div>

            <hr class="hr-pencil">

            <div class="row comercial-detail">
                <div class="col-sm-12">
                    <h1>Datos Comerciales DóndePauto</h1>
                    <div class="col-md-10 col-md-offset-1">
                        <div class="ibox ibox-dashboard float-e-margins">
                            <div class="ibox-content" style="display: block;">
                                <div class="row files-pauto">
                                    <div class="col-xs-6">
                                        <a href="/files/camara_comercio.pdf"  target="_blank" class="comercial-file"> <img src="/assets/img/dashboard/iconopdfgris.png" class="img-icon"> camara de comercio</a>
                                    </div>
                                    <div class="col-xs-6">
                                        <a href="/files/rut_donde_pauto.pdf" target="_blank" class="comercial-file"> <img src="/assets/img/dashboard/iconopdfgris.png" class="img-icon"> rut</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>   

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Solicitar cambio de información</h4>
          </div>
          <div class="modal-body">
            {!! Field::textarea('comments', ['id' => 'comments-message', 'label' => 'Para modificar o reemplazar la información registrada en DóndePauto, déjanos un mensaje aquí.  Un asesor de servicio se comunicará con usted en breve.', 'required', 'placeholder' => '', 'data-url' => route('medios.agreement.change', $publisher) ]) !!}
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="sendMessage();">Enviar mensaje</button>
          </div>
        </div>
      </div>
    </div> 
   
@endsection

@section('extra-js')
    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

    <script type="text/javascript">
        function sendMessage() {
            $(".se-pre-con").delay(700).show(0);
            $.post($("#comments-message").data('url'), {'comments': $("#comments-message").val()} )
                .done( function(data, status) {
                    $("#comments-message").val('');
                    $(".se-pre-con").delay(400).hide(0); 
                    swal({
                        title: 'Gracias',
                        text: 'Hemos recibido sus comentarios y pronto un asesor de servicios lo contactará',
                        type: "success",
                        confirmButtonText: "Continuar",
                        confirmButtonColor: "#FFAC1A",
                        html: true
                    });
                });
        }
    </script>


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
            $('.pieProgress').asPieProgress('go', $("#avgPoints").data('points'));
        });
    </script>
@endsection