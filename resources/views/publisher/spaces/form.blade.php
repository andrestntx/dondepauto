@extends('layouts.publisher')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('extra-css')
    <link href="/assets/css/plugins/steps/jquery.steps.css" rel="stylesheet">
    <link href="/assets/css/plugins/dropzone/basic.css" rel="stylesheet">
    <link href="/assets/css/plugins/dropzone/dropzone.css" rel="stylesheet">
    <link href="/assets/css/publish.css" rel="stylesheet">
@endsection

@section('content')
    <div class="se-pre-con"></div>
    <div id="serverImages" data-images="{{ $space->images_list }}"></div>
    
    <div class="col-md-8 col-md-offset-2 text-center">
        <h2 id="title-page">
            @if($publisher->has_offers)
                Presentar mi primera oferta
            @elseif($space->exists)
                Editar oferta
            @else
                Presentar oferta nueva
            @endif
        </h2>
        <p id="info-page">Antes de publicar tu oferta, ten en cuenta <a href="esta información!" data-toggle="modal" data-target="#modalInfo">esta información</a></p>
        <div class="modal inmodal" id="modalInfo" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content animated fadeIn">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                        <h4 class="modal-title">Consejos para crear ofertas con mayor potencial de venta!</h4>
                    </div>
                    <div class="modal-body">
                        <ul>
                            <li><strong>Cada Oferta</strong> podrá representar <strong>un (1) espacio publicitario específico</strong>, o un <strong>paquete de varios Espacios publicitarios</strong>. Haz clara esta diferencia en el título de la oferta, en el precio y en la descripción.</li>

                            <li>Puedes crear diferentes <strong>variaciones de Ofertas</strong> sobre un espacio publicitario puntual. Define diferentes precios en diferentes periodos de venta, tiempos, frecuencias o cantidades. Brinda más alternativas y obtén mayores prospectos de clientes según necesidades específicas.</li>

                            <li>En DóndePauto creas <strong>Ofertas de Referencia.</strong> NO se publican las disponibilidades del espacio publicitario. Cada vez que haya un anunciante interesado en una oferta, DóndePauto contacta al Medio para confirmar si está disponible y no hay restricción para este anunciante.</li>

                            <li>Si un Anunciante se interesa por tus Ofertas de Referencia, se podrán <strong>negociar y contratar diferentes cantidades, frecuencia de salidas y tiempos de exposición.</strong> El Precio final se ajusta según lo acordado entre el Medio y Anunciante.</li>

                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-10 col-md-offset-1" id="conten-page">
        <div class="ibox">       
            <div class="ibox-content">
                
                <div class="row">
                    <div class="col-md-3" id="points" data-totalpoints="{{ $space->new_points }}">
                        <div id="fixedPoints">
                            <div class="pieProgress" role="progressbar" data-goal="100" aria-valuemin="0" data-step="2" aria-valuemax="100">
                                <div class="pie_progress__number">0</div>
                            </div>
                            <a id="title-point" data-toggle="modal" data-target="#modalPoints">Puntaje</a>
                            <div class="modal inmodal" id="modalPoints" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                                            <i class="fa fa-line-chart modal-icon"></i>
                                            <h4 class="modal-title">Puntaje</h4>
                                            <h5 class="modal-subtitle">Mejora tu puntaje siguiendo nuestros consejos</h5>
                                        </div>
                                        <div class="modal-body">
                                            <p>El Puntaje califica que tan completa, precisa, y clara es la información registrada en la oferta, lo que aporta mayor valor, rapidez y seguridad a los Anunciantes en la toma de decisiones de compra. 
                                            </p>
                                            <p>Ofertas con mayores puntajes tienen mejor exposición en la Plataforma y captan mayor interés.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="messages">
                                <a class="mclose"></a>
                                <div class="loading">
                                    <img src="/assets/img/iconoi.png">
                                    <div class="sk-spinner sk-spinner-three-bounce sk-publish" id="bounces">
                                        <div class="sk-bounce1"></div>
                                        <div class="sk-bounce2"></div>
                                        <div class="sk-bounce3"></div>
                                    </div>
                                </div>
                                <h3 id="message-title">Titulo del espacio publicitario</h3>
                                <p id="message-text">El título de la oferta es clave para captar la atención del anunciante. Ingresa un título preciso, entre 90 y180 caracteres, que permita identificar rápida y fácilmente las características básicas de la oferta</p>
                                <a class="btn btn-warning btn-block" id="activate">Mostrar consejos</a>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-9" id="spaceRules" data-rules="{{ $space->rules_json }}">
                        {!! Form::model($space, ['route' => $route, 'files' => true, 'enctype' => 'multipart/form-data', 'id' => 'form-publish', 'class' => 'wizard-big form-steps', 'method' => $type, 'data-typeform' => $type]) !!}
                            <h1>Datos básicos</h1>
                            <fieldset>
                                <h2>Datos básicos de este espacio publicitario</h2>
                                <div class="row">
                                    {{-- <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="control-label">Hacer publica esta oferta</label>
                                            <div class="control">
                                                <input name="public" type="checkbox" class="js-switch" />    
                                            </div>
                                        </div>
                                    </div> --}}
                                   
                                    <div class="col-lg-12">
                                        {!! Field::text('name', ['label' => 'Título del espacio publicitario', 'ph' => 'Ejemplo: Pantalla Digital en Hall Principal centro comercial Unicentro Bogotá', 'required']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Field::select('category_id', $categories, ['label' => 'Categoría (Tipo de pauta del espacio)', 'class' => 'select2-category', 'required']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        @if($space->format_id)
                                            {!! Field::select('format_id', $spaceFormats, ['class' => 'select2-format', 'required', 'data-formats' => $formats, 'id' => 'format_id', 'empty' => 'Primero seleccione la categoría', 'label' => 'Formato del espacio']) !!}
                                        @else
                                            {!! Field::select('format_id', ['' => ''], ['class' => 'select2-format', 'required', 'disabled', 'data-formats' => $formats, 'id' => 'format_id', 'empty' => 'Primero seleccione la categoría', 'label' => 'Formato del espacio']) !!}
                                        @endif
                                    </div>
                                    <div class="col-md-12">
                                        {!! Field::textarea('description', ['label' => 'Descripción del espacio', 'ph' => 'Brinda información completa de beneficios, tiempos, variaciones, horarios, ubicaciones, tamaños, frecuencias de salida, y cualquier información de interés para el anunciante y su agencia', 'required', 'rows' => '5']) !!}
                                    </div>
                                    <div class="col-lg-12">
                                        {!! Field::text('dimension', ['label' => 'Dimensiones o tamaño', 'ph' => 'Ejemplo: 3 x 4 metros; 1m Alto x 2m Ancho']) !!}
                                    </div>
                                </div>
                            </fieldset>

                            <h1>Perfil de audiencias</h1>
                            <fieldset>
                                <h2>Datos de la audiencia impactada</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Field::select('impact_scenes', $scenes, $space->impact_scenes_list, ['multiple', 'required', 'data-placeholder' => 'Selecciona los escenarios donde se encuentra el espacio publicitario']) !!}
                                    </div>
                                    <div class="col-md-12">
                                        {!! Field::select('audiences', $audiences, $space->audiences_list, ['label' => 'Perfil de audiencias', 'data-placeholder' => 'Seleccione las audiencias del espacio publicitario',  'class' => 'select2-audience', 'required', 'multiple']) !!}
                                    </div>

                                    <div class="col-lg-12">
                                        {!! Field::text('more_audiences', ['label' => 'Agrega más audiencias y etiquetas', 'ph' => 'Casados, Solteros, Constructores', 'required', 'class' => 'tags']) !!}
                                    </div>
                                   
                                    <div class="col-md-6">
                                        {!! Field::number('impact', ['ph' => 'Cantidad de personas que impacta tu espacio', 'label' => 'Impactos estimados']) !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Field::text('impact_agency', ['ph' => 'Agencia que calcula la medición. Ej: IBOPE', 'label' => 'Fuente de la cifra de impactos']) !!}
                                    </div>

                                    <div class="col-md-12">
                                        <legend class="h4" style="padding-top: 10px; margin-bottom:0;">Restricciones</legend>
                                        <div class="col-md-2" style="padding-top: 10px;">
                                            <div class="checkbox m-r-xs text-center">
                                                {!! Form::checkbox('alcohol_restriction', 1, $space->alcohol_restriction_bool, ['id' => 'alcohol_restriction']) !!}
                                                <label for="alcohol_restriction" title="No se permite hacer publicidad de licores">
                                                    Alcohol
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="padding-top: 10px;">
                                            <div class="checkbox m-r-xs text-center">
                                                {!! Form::checkbox('snuff_restriction', 1, $space->snuff_restriction_bool, ['id' => 'snuff_restriction']) !!}
                                                <label for="snuff_restriction" title="No se permite hacer publicidad de tabaco">
                                                    Tabaco
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="padding-top: 10px;">
                                            <div class="checkbox m-r-xs text-center">
                                                {!! Form::checkbox('policy_restriction', 1, $space->policy_restriction_bool, ['id' => 'policy_restriction']) !!}
                                                <label for="policy_restriction" title="No se permite hacer publicidad de política">
                                                    Política
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px;">
                                            <div class="checkbox m-r-xs text-center">
                                                {!! Form::checkbox('sex_restriction', 1, $space->sex_restriction_bool, ['id' => 'sex_restriction']) !!}
                                                <label for="sex_restriction" title="No se permite hacer publicidad con contenido sexual">
                                                    Contenido sexual
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="padding-left: 10px; padding-top: 10px;">
                                            <div class="checkbox m-r-xs text-center">
                                                {!! Form::checkbox('religion_restriction', 1, $space->religion_restriction_bool, ['id' => 'religion_restriction']) !!}
                                                <label for="religion_restriction" title="No se permite hacer publicidad con contenido religioso">
                                                    Religión
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        {!! Field::select('cities', $cities, $space->cities_list, ['label' => 'Ciudades', 'class' => 'select-cities', 'data-placeholder' => 'Ciudades donde se encuentra el espacio publicitario', 'multiple', 'required']) !!}
                                    </div>

                                    <div class="col-md-12">
                                        {!! Field::text('address', ['ph' => 'Ejemplo: Carreara 11a # 119 - 35']) !!}
                                    </div>
          
                                </div>
                            </fieldset>

                            <h1>Imágenes y videos</h1>
                            <fieldset>
                                <h2>Imágenes y videos</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">Agregue las fotografías del espacio publicitario</label>
                                            <div id="myDropzone" class="dropzone">
                                                <div class="fallback">
                                                    <input name="images" type="file" multiple />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        {!! Field::text('youtube', ['label' => 'Link de video en Youtube', 'ph' => 'Ejemplo: https://www.youtube.com/watch?v=tReswSGoKys']) !!}
                                    </div>
                                </div>
                            </fieldset>

                            <h1>Precio</h1>
                            <fieldset>
                                <h2>Precio</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Field::number('price', $space->minimal_price, ['label' => 'Precio base (sin IVA)', 'ph' => 'Precio base del espacio (Sin IVA)', 'required']) !!}
                                    </div>
                                    <div class="col-md-12">
                                        {!! Field::select('period', $periods, ['empty' => 'seleccione un período', 'required', 'label' => 'Periodo de venta']) !!}
                                    </div>
                                    <div class="col-md-12">
                                        {!! Field::number('discount', ['label' => 'Descuento para cliente final', 'ph' => 'Descuento para motivar la venta', 'style' => 'margin-bottom: 0.5em;', 'autocomplete' => 'off', 'min' => '0', 'max' => '100', 'required']) !!}
                                        <p id="text_discount" style="display:none; margin-bottom: 1.5em;"></p>
                                    </div>

                                    <input type="hidden" name="minimal_price" value="0">
                                    <input type="hidden" name="public_price" value="0">
                                    <input type="hidden" name="margin" value="0">

                                    <div class="col-md-12" id="with_discount" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-7" id="discount_labels">
                                                <p id="label_discount"><strong>Descuento máximo para cliente:</strong></p>
                                                <p><strong>Precio mínimo de Venta:</strong></p>  
                                                <p id="label_our_discount"><strong>Margen de negociación:</strong></p>
                                                <p id="label_public_price"><strong>Precio de Oferta al Público:</strong></p>                                                
                                            </div>
                                            <div class="col-md-5" id="discount_values">
                                                <p id="max_discount"><span></span>%
                                                    <a class="btn btn-info btn-xs-circle" tabindex="0" data-toggle="popover" data-placement="top" data-content="a" role="button" data-trigger="focus">
                                                    <i class="fa fa-question"></i></a>
                                                </p>

                                                <p id="minimal_price">$<span ></span> <span class="period_value"></span>
                                                    <a class="btn btn-info btn-xs-circle" tabindex="0" data-toggle="popover" data-placement="top" data-content="a" role="button" data-trigger="focus">
                                                    <i class="fa fa-question"></i></a>
                                                </p>  

                                                <p id="our_discount" style="display:none;"><span> </span>
                                                    <a class="btn btn-info btn-xs-circle" tabindex="0" data-toggle="popover" data-placement="top" data-content="a" data-trigger="focus">
                                                    <i class="fa fa-question"></i></a>
                                                </p>

                                                <p id="public_price">$<span></span> <span class="period_value"></span>
                                                <a class="btn btn-info btn-xs-circle" tabindex="0" data-toggle="popover" data-placement="top" data-content="a" role="button" data-trigger="focus">
                                                    <i class="fa fa-question"></i></a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                        {!! Form::close() !!}  
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection

@section('extra-js')    
    <script src="/assets/js/services/publishService.js"></script>

@endsection