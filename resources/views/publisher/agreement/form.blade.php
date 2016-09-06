@extends('layouts.publisher')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="/assets/css/publisher/dashboard.css" />
    <link href="/assets/css/plugins/slick/slick.css" rel="stylesheet">
    <link href="/assets/css/plugins/slick/slick-theme.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')
    <div class="se-pre-con"></div>

    <div class="dashboard">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 slide-tips">
            <h2 class="text-center m">
                ¿Por qué validamos a los Medios Publicitarios?
            </h2>
            <h3 class="text-center m">
                DóndePatuo busca generar confianza entre las marcas anunciantes que compran a través de su plataforma. <strong>Para esto verificamos:</strong>
            </h3>
        </div>

        <div class="col-xs-12 col-sm-10 col-sm-offset-1 slide-tips" id="slide">
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
                                    <div>
                                        <div class="ibox-content">
                                            <p>
                                                DóndePauto inactiva las cuentas y ofertas que no cuenten con las validaciones descritas, o cuando no pueda verificar la información que el Medio Publicitario haya registrado
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
                <div class="horizontal-line hidden-xs hidden-sm">
                </div>
            </div>

            <div class="col-sm-8">
                <h2>Carta de aceptación de términos de la plataforma</h2>
                <p class="intro-form">Para generar el borrador de la <strong>Carta de Aceptación y de Incentivo Económico</strong>, por favor registra la información exacta de su empresa y de su Representante Legal</p>

                {!! Form::open(['id' => 'data-agreement', 'type' => 'POST']) !!}
                    <div class="col-xs-12">
                        <div class="ibox float-e-margins ibox-content-margin">
                            <div class="ibox-title">
                                <h3 class="text-title">
                                    Formulario de Datos del Medio Publicitario y Representante Legal
                                </h3>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <div class="col-md-6"> 
                                            {!! Field::text('publisher[company_legal]', $publisher->company_legal, ['label' => 'Razón social', 'required']) !!} 
                                        </div>
                                        <div class="col-md-6"> 
                                            {!! Field::text('publisher[company_nit]', $publisher->company_nit, ['label' => 'NIT', 'required']) !!} 
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-6"> 
                                            {!! Field::select('publisher[city_id]', $cities, $publisher->city_id, ['label' => 'Ciudad', 'empty' => 'Ciudad de la Oficina Principal.', 'class' => 'select2-cities', 'required']) !!}
                                        </div>
                                        <div class="col-md-6"> 
                                            {!! Field::text('publisher[address]', $publisher->address, ['label' => 'Dirección Empresa', 'required']) !!} 
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-6"> 
                                            {!! Field::text('repre[name]', $representative->name, ['label' => 'Nombre Rep. Legal', 'required']) !!} 
                                        </div>
                                        <div class="col-md-6"> 
                                            {!! Field::email('repre[email]', $representative->email, ['label' => 'Email Rep. Legal', 'required']) !!} 
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-6"> 
                                            {!! Field::number('repre[doc]', $representative->doc, ['label' => 'Cédula Rep. Legal', 'required']) !!} 
                                        </div>                                    
                                        <div class="col-md-6"> 
                                            {!! Field::text('repre[phone]', $representative->phone, ['label' => 'Teléfono Fijo Rep. Legal', 'required']) !!} 
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="col-md-6"> 
                                            {!! Field::number('publisher[commission_rate]', $publisher->commission_rate, ['label' => 'Comisión', 'required']) !!} 
                                        </div>                                    
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> 

                    <div class="col-xs-12 btn-save-agreement">
                        <img src="/assets/img/agreement/download.png" id="generate-pdf">
                    </div>

                    {!! Form::close() !!}
            </div>
        </div>

        <div class="col-xs-12 agreement-form" style="margin-top: 5em;">
            <div class="col-sm-2">
                <img src="/assets/img/agreement/icono1.png" class="icon-steps">
                <div class="horizontal-line hidden-xs hidden-sm">
                </div>
            </div>

            <div class="col-sm-8 documents">
                <h2>Documentos para validación de medio Publicitario</h2>

                @if($publisher->in_update_documents)
                    @include('publisher.agreement.only-form')
                @else
                    @include('admin.publishers.agreement-form')
                @endif

            </div>
        </div>
    </div>    

    <div class="modal inmodal fade in" id="modalFiles" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i class="fa fa-exclamation-circle modal-icon"></i>
                    <h4 class="modal-title" id="modalTitle">{{ $publisher->company }}</h4>
                </div>
                <div class="modal-body" id="modalText">
                    <p style="font-size: 15px; text-align: justify; margin-bottom: 10px; color:black;">Tu información comercial y societaria se ha registrado exitosamente. Dóndepauto verificará la información para activar su medio publicitario como proveedor</p>
                    <p style="font-size: 15px; text-align: justify; margin-bottom: 10px; color:black;">Una vez verificada esta información tus ofertas se activarán en la plataforma y podrán ser promocionadas y presentadas a potenciales clientes interesados.</p>
                    <p style="font-size: 15px; text-align: justify; margin-bottom: 10px; color:black;">Si no has publicado todas tus ofertas, <a href="/">ingresa aquí</a></p>
                </div>

                <div class="modal-footer">
                    <a href="/" class="btn btn-warning" style="margin: 0 auto; position: relative; width: 130px; display: block; font-size: 1.2em;">Continuar</a>
                </div>
            </div>
        </div>
    </div>
   
@endsection

@section('extra-js')
    <!-- slick carousel-->
    <script src="/assets/js/plugins/custom-file/custom-file-input.js"></script>
    <script src="/assets/js/plugins/slick/slick.min.js"></script>
    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
    
    <script>
        $('.slick-tips').slick({
            dots: true
        });

        $(document).ready(function(){
            
            var messages = {
                "publisher[company_legal]": {
                    default: "Escriba la razón social como aparece en su Cámara Comercio. EJ: DONDEPAUTO SAS.",
                    required: "",
                    minlength: ""
                },
                "publisher[company_nit]": {
                    default: "Ingrese el NIT, con puntos y con dígito verificación. EJ: 900.774.988-7",
                    required: "",
                    minlength: "Ingrese un NIT válido",
                    maxlength: "Ingrese un NIT válido"
                },
                "publisher[city_id]": {
                    default: "Seleccione la ciudad donde se encuentra su Oficina Principal",
                    required: ""
                },
                "publisher[address]": {
                    default: "Escriba la dirección de la Oficina Principal.",
                    required: "",
                    minlength: ""
                },
                "publisher[commission_rate]": {
                    default: "Comisión de incentivos",
                    required: ""
                },
                "repre[name]": {
                    default: "Nombre Completo del representante legal del Medio Publicitario",
                    required: "",
                    minlength: ""
                },
                "repre[email]": {
                    default: "Escriba el correo electrónico corporativo del Rep Legal.",
                    required: "",
                    minlength: ""
                },
                "repre[doc]": {
                    default: "Ingrese el número de cédula del Rep. Legal. EJ: 91517500",
                    required: "",
                    minlength: ""
                },
                "repre[phone]": {
                    default: "Escriba el teléfono fijo de la Oficina. Ej: (1) 6314163 Ext: 310",
                    required: "",
                    minlength: ""
                },
                "signed_agreement": {
                    default: "",
                    required: "."
                }
            };

            $("button.confirm").bind('click', function() {
                alert('sisis');
            });

            $("#form-files").bind('submit', function (e) {
                e.preventDefault();

                if($("#signed_agreement").is(':checked')) {
                    $(this).ajaxSubmit({
                        beforeSubmit: function(arr, $form, options) { 
                            $(".se-pre-con").delay(700).show(0);          
                        },
                        success: function(data) {
                            $(".se-pre-con").delay(400).hide(0); 
                            //$('#modalFiles').modal('show');
                            swal({
                                title: $("#modalTitle").html(),
                                text: $("#modalText").html(),
                                type: "success",
                                confirmButtonText: "Continuar",
                                confirmButtonColor: "#FFAC1A",
                                html: true
                            },
                            function() {
                                window.location.href = "/";
                            });
                        }
                    });
                }
                else {
                    swal({
                        title: "¡Atención!",
                        text: "Debe aceptar los terminos y condiciones",
                        type: "warning",
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonText: "Regresar",
                    });
                }

                return false;
            });

            $("form#data-agreement").validate({
                debug: true,
                submitHandler: function(form) {
                    $(form).ajaxSubmit();
                },
                rules: {
                    "publisher[company_legal]": {
                        required: true,
                        minlength: 3
                    },
                    "publisher[company_nit]": {
                        required: true,
                        minlength: 13,
                        maxlength: 13
                    },
                    "publisher[city_id]": {
                        required: true
                    },
                    "publisher[address]": {
                        required: true,
                        minlength: 3
                    },
                    "publisher[commission_rate]": {
                        required: true
                    },
                    "repre[name]": {
                        required: true,
                        minlength: 3
                    },
                    "repre[email]": {
                        required: true,
                        minlength: 3
                    },
                    "repre[doc]": {
                        required: true,
                        minlength: 3
                    },
                    "repre[phone]": {
                        required: true,
                        minlength: 3
                    }
                },
                messages: messages
             });

            $("form#data-agreement input.form-control").focus(function() {
                $(".label-message").remove();
                id      = $(this).attr('id');
                message = messages[id].default;
                $(this).after('<span id="label-message-' + id + '" class="label-message">' + message + '</span>');
            });

            $("#generate-pdf").click(function(){
                if($("form#data-agreement").valid()) {
                    $("form#data-agreement").ajaxSubmit({
                        beforeSubmit: function(arr, $form, options) { 
                            $(".se-pre-con").delay(700).show(0);          
                        },
                        success: function(data) {
                            if(data.file.length > 0) {
                                var link = document.createElement("a");
                                link.download = 'carta_representante_legal.pdf';
                                link.href = data.file;
                                link.click();
                            }
                            $(".se-pre-con").delay(800).hide(0);  
                        }
                    });
                }
            });
        });
    </script>
@endsection