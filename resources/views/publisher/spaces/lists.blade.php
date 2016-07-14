@extends('layouts.publisher-datatable')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="/assets/css/publisher/dashboard.css" />
    <link href="/assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="/assets/css/plugins/tour/bootstrap-tour.min.css" rel="stylesheet">
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
                        <h1 id="avgPoints" data-points="{{ $publisher->avg_points }}">Mi inventario de Medios</h1>
                    </div>
                </div>  
            </div>          
        </div>

        <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 inventary">
            <div class="col-xs-4" id="pointsInventary">
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
            <div class="col-xs-4">
                <h1> <img src="/assets/img/dashboard/iconototalof.png" class="img-icon"> Total de ofertas</h1>
                <h2>{{ $publisher->spaces->count() }}</h2>
            </div>
            <div class="col-xs-4">
                <h1> <img src="/assets/img/dashboard/iconovalorport.png" class="img-icon">  Valor de portafolio</h1>
                <h2 id="price-inventary">${{ number_format($publisher->spaces->sum('minimal_price'), 0, ',', '.') }}</h2>
            </div>
        </div>

        <div class="col-md-12 list-spaces" id="listSpaces">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12" style="padding: 20px 0;">
                        <div class="col-md-6">
                            <a href="javascript:void(0);" id="restart-tour" class="btn btn-info" style="width: 38px; height: 38px; margin-right: 7px; float: left; padding: 5px 0;"><i class="fa fa-question-circle" style="font-size: 24px;"></i></a>
                            <input type="text" id="myInputTextField" placeholder="Buscar.." class="form-control" style="border: 2px solid #cecdcd; float: left; width: 80%; height: 38px; ">
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('medios.espacios.create', $publisher) }}" class="btn btn-warning btn-effect-ripple create-datatable">
                                <i class="fa fa-plus-circle"></i> CREAR NUEVA OFERTA
                            </a> 
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="inventary-datatable" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th id="active-space">Activa</th>
                                        <th>Espacio Publicitario</th>
                                        <th id="copy-space"></th>
                                        <th>Categoría</th>
                                        <th>Formato</th>
                                        <th class="text-center">$ Base</th>
                                        <th class="text-center">Puntaje</th>
                                        @if($publisher->private)
                                            <th class="text-center">Privacidad</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($publisher->spaces as $space)
                                        <tr>
                                            <td class="text-center"> 
                                                <div class="checkbox checkbox-info text-center">
                                                    {{ Form::checkbox('active[$space->id]', 1, $space->active) }}
                                                    <label></label>
                                                </div> 
                                            </td>
                                            <td> <a href="{{ route('medios.espacios.show', [$publisher, $space]) }}" target="_blank"> {{ $space->name }} </a></td>
                                            <th class="text-center"> <a href="/" class="btn btn-sm btn-warning" style="font-size: 0.9em;">Crear oferta similar</a></th>
                                            <td> {{ $space->category_name }} / {{ $space->sub_category_name }} </td>
                                            <td> {{ $space->format_name }} </td>
                                            <td class="text-center" style="color:#1ab394;"> <strong> ${{ number_format($space->minimal_price, 0, ',', '.') }} </strong> </td>
                                            <td class="text-center"> <strong>{{ $space->points }} </strong></td>
                                            @if($publisher->private)
                                                <td class="text-center"> 
                                                    @if($space->private)
                                                        <span class="label label-default">Privada</span>
                                                    @else
                                                        <span class="label label-primary">Pública</span>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
   
@endsection

@section('extra-js')

    <script src="/assets/js/services/publisher/inventaryService.js"></script>
    <script src="/assets/js/plugins/tour/bootstrap-tour.min.js"></script>

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
            InventaryService.init('/medios/search');
            $("#inventary-datatable_length").hide(0); 
            $("#inventary-datatable_filter").hide(0);

            var tour = new Tour({
                steps: [
                  {
                    element: "#title-point",
                    title: "Puntaje",
                    content: "Este es el puntaje promedio de tus ofertas. Mide que tan precisa y clara es la información. A mayor puntaje, mayor prioridad en presentaciones a clientes. ",
                    placement: "right"
                  },
                  {
                    element: "#price-inventary",
                    title: "Valor Portafolio",
                    content: "Esta es la sumatoria del valor (precio) de todas tus ofertas.",
                    placement: "bottom"
                  },
                  {
                    element: "#active-space",
                    title: "Activar / Desactivar Oferta",
                    content: "Activa o Desactiva ofertas que ya no tengas disponibles, si aún no deseas eliminarla.",
                    placement: "top"
                  },
                  {
                    element: "#copy-space",
                    title: "Crear oferta similar",
                    content: "Puedes duplicar una oferta ya creada, y cambia algunas características como frecuencia, cantidades, etc. ",
                    placement: "top"
                  }
                ],
               template: "<div class='popover tour' style='max-width:350px;'>" +
                              "<div class='arrow'></div>" +
                              "<h3 class='popover-title'></h3>" +
                              "<div class='popover-content'></div>" +
                              "<div class='popover-navigation'>" +
                                "<div class='btn-group'>" + 
                                    "<button class='btn btn-sm btn-default' data-role='prev'>« Anterior</button>" +
                                    "<button class='btn btn-sm btn-default' data-role='next'>Siguiente »</button>" +
                                "</div>" +
                                "<button class='btn btn-sm btn-default' data-role='end'>Terminar</button>" +
                              "</div>" +
                            "</div>"
            });


            $("#restart-tour").click(function() {
                tour.restart();
            });
        });


    </script>
@endsection