@extends('layouts.admin')

@section('extra-css')
    <link href="/assets/css/plugins/switchery/switchery.min.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.css" rel="stylesheet">
    <link href="/assets/css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">

    <link href="/assets/css/prueba.css" rel="stylesheet">

    <style type="text/css">
        .swal2-modal .swal2-select {
            background-color: #FFFFFF;
            background-image: none;
            border: 1px solid #ccc;
            border-radius: 1px;
            color: inherit;
            display: block;
            padding: 6px 12px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
            width: 100%;
            font-size: 14px;
            height: 34px;
        }

        .swal2-modal {
            z-index: 10000;    
        }
        
    </style>

@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')   
    <div class="col-sm-12 m-b-md" id="publisher" data-publisher="{{ $publisher }}" data-states="{{ json_encode($publisher->states) }}" data-datatable="{{ route('medios.espacios.search', $publisher) }}">
        <div class="ibox-title">
            <h5>Detalle del Medio - Total Espacios ({{ $spaces->total() }})</h5>
            <div class="ibox-tools">
                <a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Editar Medio" href="{{ route('medios.edit', $publisher) }}">
                    <i class="fa fa-pencil"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-4">   
                    <p>
                        <span class="h5 font-bold"> Contacto </span> <br>
                        <span class="h5"> {{ $publisher->name }} </span> <br>
                        <span class="h5"> {{ $publisher->company_role }} - {{ $publisher->company_area }} </span> <br>
                        <span class="h5"> <i class="fa fa-envelope-o"></i> <a href="mailto:{{ $publisher->email }}"> {{ $publisher->email }} </a> </span> <br>
                        <span class="h5">   
                            <i class="fa fa-phone"> </i> 
                            <a href="tel:{{ $publisher->phone }}"> {{ $publisher->phone }} </a> -
                            <i class="fa fa-mobile"></i> <a href="tel:{{ $publisher->cel }}"> {{ $publisher->cel }} </a>
                        </span>
                    </p>
                </div>
                <div class="col-sm-4">
                    <p>
                        <span class="h5 font-bold"> Ubicación </span> <br>
                        <span class="h5"> {{ $publisher->address }} </span> <br>
                        <span class="h5"> {{ $publisher->city_name }} </span> <br>
                        <span class="h5"> NIT: {{ $publisher->company_nit }} </span>
                    </p>
                </div>
                <div class="col-sm-4">
                    <p>
                        <span class="h5 font-bold"> Acuerdo ({{ $publisher->signed_agreement_lang }}) </span> <br>
                        @if($publisher->signed_agreement)
                            <span class="h5"> Porcentaje de comisión:  <span class="font-bold"> {{ $publisher->commission_rate }}% </span> </span> <br>
                            <span class="h5"> Fecha firma de acuerdo:  <span class="font-bold"> {{ $publisher->signed_at }} </span> </span> <br>
                            <span class="h5"> Descuento pronto pago:   <span class="font-bold"> {{ $publisher->discount }}% </span> </span> <br>
                            <span class="h5"> Retención en la fuente:  <span class="font-bold"> {{ $publisher->retention }}% </span> <br>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 m-t-sm">
                    <p>
                        <span class="h5 font-bold"> Comentarios </span> <br>
                        <span class="h5"> {{ $publisher->comments }} </span> <br>
                    </p>
                </div>
                <div class="col-sm-8 m-t-sm list-publisher">
                   <div class="timeline" id="prueba"> </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>Espacios de Pauta</h5>
        </div>
        <div class="ibox-content">
            @include('admin.spaces.table')
        </div>
     </div>

     @include('admin.spaces.modal')
     @include('admin.spaces.modals.suggest')

@endsection

@section('extra-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>

    <script src="/assets/js/plugins/switchery/switchery.min.js"></script>
    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.js"></script>
    <!-- blueimp gallery -->
    <script src="/assets/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>

    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/publisherService.js"></script>
    <script src="/assets/js/services/spaceService.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            PublisherService.drawShowPrices();
            SpaceService.initDatatable($('#publisher').data('datatable'));
            SpaceService.initModalEvent(false);
            SpaceService.initPostSuggest();
            $('.advertisr-chosen-select').chosen({width: "100%"});
        });
    </script>
@endsection