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
                <p class="intro-form">Para generar el borrador de la <strong>Carta de Aceptación y de Incentivo Económico</strong>, que deberá ser firmada por el Representante Legal del Medio Publicitario y enviada en original a las oficinas de DóndePauto, por favor registra la información exacta de su empresa y de su Representante Legal</p>

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
                                            {!! Field::text('repre[doc]', $representative->doc, ['label' => 'Cédula Rep. Legal', 'required']) !!} 
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

        <div class="col-xs-12 agreement-form">
            <div class="col-sm-2">
                <img src="/assets/img/agreement/icono1.png" class="icon-steps">
                <div class="horizontal-line hidden-xs hidden-sm">
                </div>
            </div>

            <div class="col-sm-8 documents">
                <h2>Documentos para validación de medio Publicitario</h2>
                <p class="intro-form">Para validar la existencia y representación legal de <strong>{{ $publisher->company }}</strong> por favor subir la siguiente documentación en formato PDF</p>

                {!! Form::open(['route' => ['medios.agreement.complete.upload', $publisher], 'files' => 'true', 'id' => 'form-files']) !!}
                    <div class="row">
                        <div class="col-md-12 file-content">
                            <div class="col-sm-6">
                                <p><strong>Cámara de Comercio:</strong> Para verificar la existencia y capacidad legal para la venta de espacios publicitarios.</p>
                            </div>
                            <div class="col-sm-6 js">
                                {!! Form::file('commerce', ['class' => 'inputfile', 'id' => 'commerce', 'required']) !!}
                                <label for="commerce">
                                    <figure><img src="/assets/img/agreement/iconopdf.png"></figure>
                                    <div class="label-text">
                                        <span class="upload-label">Cárama de comercio</span> 
                                        <span class="upload-pdf">Subir PDF</span>
                                        <span class="upload-text">(Expedición no mayor a 60 días)</span>  
                                    </div>
                                    <div class="label-check">
                                        <i class="fa fa-check"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 file-content">
                            <div class="col-sm-6">
                                <p><strong>RUT:</strong> Para verificar la actividad económica, forma de facturación y retenciones aplicablespor su actividad económica.</p>
                            </div>
                            <div class="col-sm-6 js">
                                {!! Form::file('rut', ['class' => 'inputfile', 'id' => 'rut', 'required']) !!}
                                <label for="rut">
                                    <figure><img src="/assets/img/agreement/iconopdf.png"></figure>
                                    <div class="label-text">
                                        <span class="upload-label">RUT</span> 
                                        <span class="upload-pdf">Subir PDF</span>
                                    </div>
                                    <div class="label-check">
                                        <i class="fa fa-check"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 file-content">
                            <div class="col-sm-6">
                                <p><strong>Certificación Bancaria:</strong> Para registrar en nuestro sistema la cuenta bancaria a donde se harán las transferencias al medio publicitario.</p>
                            </div>
                            <div class="col-sm-6 js">
                                {!! Form::file('bank', ['class' => 'inputfile', 'id' => 'bank', 'required']) !!}
                                <label for="bank">
                                    <figure><img src="/assets/img/agreement/iconopdf.png"></figure>
                                    <div class="label-text">
                                        <span class="upload-label">Certificación Bancaria</span> 
                                        <span class="upload-pdf">Subir PDF</span>
                                    </div>
                                    <div class="label-check">
                                        <i class="fa fa-check"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12 file-content">
                            <div class="col-sm-6">
                                <p><strong>Carta de Aceptación e Incentivos del Representante Legal:</strong> Para validar que se aceptan los términos y condiciones de la Plataforma, se formaliza el incentivo de comisión para DóndePauto, y confirmar el registro del funcionario que administrará y formulará las ofertas del Medio Publicitario.</p>
                            </div>
                            <div class="col-sm-6 js">
                                {!! Form::file('letter', ['class' => 'inputfile', 'id' => 'letter', 'required']) !!}
                                <label for="letter">
                                    <figure><img src="/assets/img/agreement/iconopdf.png"></figure>
                                    <div class="label-text">
                                        <span class="upload-label">Carta de Representante Legal</span> 
                                        <span class="upload-pdf">Subir PDF</span>
                                    </div>
                                    <div class="label-check">
                                        <i class="fa fa-check"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12" style="padding-left: 35px; padding-top: 10px;">
                            <div class="checkbox m-r-xs">
                                {!! Form::checkbox('signed_agreement', 1, 0, ['id' => 'signed_agreement']) !!}
                                <label for="signed_agreement">
                                    Acepto 
                                </label>
                                <span style="font-size: 1.15em; font-weight: 600;">los <a href="#" style="color: #2cbaf8;">términos y condiciones</a> del acuerdo servicio</span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p class="intro-form last-intro">¡Una vez suministrada la información requerida, se validarán las ofertas del Medio Publicitario y DóndePauto activará la promoción y presentación de las ofertas a potenciales clientes Anunciantes!</p>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-warning btn-effect-ripple btn-lg">REGISTRAR DOCUMENTOS</button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
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
                    <p style="font-size: 15px; text-align: justify; margin-bottom: 10px; color:black;">Una vez verificada esta información tus ofertas se activarán en la plataforma y podrán ser promocionadas y presentadas a potenciales clientes interesados. Si no has publicado todas tus ofertas, <a href="/">ingresa aquí</a></p>
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
                    default: "Ingrese el número de cédula del Rep. Lega, separado por puntos. EJ: 91.517.500",
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
                    alert('Debe aceptar los terminos y condiciones');
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