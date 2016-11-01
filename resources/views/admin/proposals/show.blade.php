@extends('layouts.admin')

@section('extra-css')
    <link href="/assets/css/plugins/switchery/switchery.min.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
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

        .proposal-detail .h5 {
            font-size: 13px;
        }

        .proposal-detail .h5.subprices {
            margin-left: 10px;
        }

        .proposal-detail .percentage {
            font-size: 11px;
            color: #989898;
        }

        .proposal-detail .percentage.text-warning {
            color: #f8ac59;
        }

        #modalContacts .form-control {
            margin-bottom: 10px;
            display: block;
            max-width: 100px;
        }

        .space_form_discount p {
            font-size: 15px;
        }

        .space_form_discount .values p {
            font-weight: 400;
        }
        
    </style>

@endsection

@section('breadcrumbs')
    <h2 style="color:#dc780b; font-weight: 300; font-size: 26px;">{{ $proposal->title }}</h2>
    <h3 style="font-size: 20px;">{{ ucfirst($advertiser->company) }}</h3>
@endsection

@section('action')
    <div style="padding: 1em 0;">
        <a href="{{ route('proposals.preview-html', $proposal) }}" class="btn btn-sm btn-success" target="_blank" title="HTML"><i class="fa fa-list-alt"></i> Previsualizar</a>

        <a href="{{ route('proposals.preview-all-pdf', $proposal) }}" class="btn btn-sm btn-warning" target="_blank" title="PDF"><i class="fa fa-file-pdf-o"></i> Cotización</a>

        <button class="btn btn-sm btn-primary" title="Enviar propuesta" id="sendProposal"><i class="fa fa-paper-plane"></i> Enviar propuesta</button>
    </div>
@endsection

@section('content')  
    
    <div class="col-xs-12" id="proposal" data-advertiser="{{ $advertiser }}" data-states="{{ json_encode($advertiser->states) }}" data-contacts="{{ json_encode($contacts) }}" data-proposal="{{ $proposal }}" data-datatable="{{ route('proposals.spaces.search', $proposal) }}" style="margin-bottom: 1em;">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-tracing"> Seguimiento</a></li>
                <li class=""><a data-toggle="tab" href="#tab-prices">Cifras del negocio</a></li>
                <li class=""><a data-toggle="tab" href="#tab-target">Audiencias</a></li>
                <li class=""><a data-toggle="tab" href="#tab-quote">Ficha técnica</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-tracing" class="tab-pane active">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-6 col-md-3">   
                            <p>
                                <span class="h5"> 
                                    <span style="font-weight: 200;">Razón social:</span> 
                                    {{ ucfirst($advertiser->company_legal) }} 
                                    <button class="btn btn-xs btn-success" id="proposalAdvertiser"><i class="fa fa-user"></i></button>
                                </span> <br>
                                <span class="h5"> 
                                    <span style="font-weight: 200;">Presentado a:</span> 
                                    {{ ucfirst($advertiser->name) }} 
                                </span> <br>
                                <span class="h5"> 
                                    <span style="font-weight: 200;">Cargo:</span>  {{ $advertiser->company_role }} 
                                </span> <br>
                                <span class="h5"> 
                                    <span style="font-weight: 200;">Email:</span> 
                                    <a href="mailto:{{ $advertiser->email }}"> {{ $advertiser->email }} </a> 
                                    <i class="fa fa-envelope-o"></i>
                                </span> <br>
                                <span class="h5">   
                                    <span style="font-weight: 200;">Teléfonos:</span> 
                                    <a href="tel:{{ $advertiser->phone }}"> {{ $advertiser->phone }} </a> 
                                    <i class="fa fa-phone"> </i>  -
                                    <a href="tel:{{ $advertiser->cel }}"> {{ $advertiser->cel }} </a>
                                    <i class="fa fa-mobile"></i>
                                </span> <br>
                                <span class="h5">   
                                    <span style="font-weight: 200;">Actividad cliente:</span> 
                                    {{ $advertiser->comments }} 
                                </span>
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-5" id="tabContacts">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h4 style="margin: 0;">
                                        Contactos
                                        <button id="newContact" data-url="-" class="btn btn-sm btn-success" style="padding: 0px 5px;">
                                            <i class="fa fa-plus"></i>
                                        </button>    
                                    </h4>
                                </div>
                                <div class="col-xs-12" id="proposal-contacts" style="max-height: 120px; overflow: auto; padding: 0.7em 1em;">

                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <span class="h5"> 
                                <span style="font-weight: 200;">Fecha solicitud:</span> 
                                {{ ucfirst($proposal->created_at_date) }} 
                            </span> <br>
                        </div>
                    </div>
                </div>
                <div id="tab-prices" class="tab-pane">
                    <div class="panel-body">
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <p>
                                <span class="h5 font-bold text-success"> CIFRAS DEL NEGOCIO </span> <br><br>
                                <span class="h5"> 
                                    <span style="font-weight: 200;">Total propuesta:</span>  ${{ number_format($proposal->total, 0, ',', '.') }} 
                                </span> <br> 
                                <span class="h5"> 
                                    <span style="font-weight: 200;">Total costo:</span>  ${{ number_format($proposal->total_cost, 0, ',', '.') }} 
                                </span> <br> <br> <br>
                                <span class="h5"> 
                                    <span style="font-weight: 200;">Ingresos DóndePauto:</span>  ${{ number_format($proposal->total_income_price, 0, ',', '.') }}   <span class="percentage">({{ $proposal->total_income * 100}}%)</span>
                                </span> <br>
                                <span class="h5 subprices"> 
                                    <span style="font-weight: 200;">Markup:</span>  ${{ number_format($proposal->total_markup_price, 0, ',', '.') }} <span class="percentage">({{ $proposal->total_markup * 100 }}%)</span>
                                </span> <br>
                                <span class="h5 subprices"> 
                                    <span style="font-weight: 200;">Comisión:</span>  ${{ number_format($proposal->total_commission_price, 0, ',', '.') }} <span class="percentage">({{ $proposal->total_commission * 100 }}%)</span>
                                </span>
                            </p>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <p>
                                <span class="h5 font-bold text-success"> DESCUENTOS Y BONIFICADOS </span> <br><br>
                                <span class="h5"> 
                                    <span style="font-weight: 200;">Total propuesta:</span>  <span id="pivot_total"> ${{ number_format($proposal->pivot_total, 0, ',', '.') }} </span>
                                </span> <br> 
                                <span class="h5"> 
                                    <span style="font-weight: 200;">Total costo:</span>  <span id="pivot_total_cost"> ${{ number_format($proposal->pivot_total_cost, 0, ',', '.') }} </span>
                                </span> <br> <br>
                                <span class="h5 text-warning"> 
                                    <span style="font-weight: 200;">Total descuento:</span>  <span id="total_discount_price"> -${{ number_format($proposal->total_discount_price, 0, ',', '.') }} </span> <span id="total_discount" class="percentage text-warning">({{ $proposal->total_discount * 100 }}%)</span>
                                </span> <br>
                                <span class="h5"> 
                                    <span style="font-weight: 200;">Ingresos DóndePauto:</span>  <span id="pivot_total_income_price"> ${{ number_format($proposal->pivot_total_income_price, 0, ',', '.') }} </span>   <span id="pivot_total_income" class="percentage">({{ $proposal->pivot_total_income * 100}}%)</span>
                                </span> <br>
                                <span class="h5 subprices"> 
                                    <span style="font-weight: 200;">Markup:</span>  <span id="pivot_total_markup_price"> ${{ number_format($proposal->pivot_total_markup_price, 0, ',', '.') }} </span> <span id="pivot_total_markup" class="percentage">({{ $proposal->pivot_total_markup * 100 }}%)</span>
                                </span> <br>
                                <span class="h5 subprices"> 
                                    <span style="font-weight: 200;">Comisión:</span>  <span id="pivot_total_commission_price"> ${{ number_format($proposal->pivot_total_commission_price, 0, ',', '.') }} </span> <span id="pivot_total_commission" class="percentage">({{ $proposal->pivot_total_commission * 100 }}%)</span>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                <div id="tab-target" class="tab-pane">
                    <div class="panel-body">
                        <div class="row">
                            @foreach($proposal->spaceAudiences->groupBy("type_name") as $type => $audiences)
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="row">
                                        <figure class="col-xs-2 col-sm-3">
                                            <img src="{{ $audiences->first()->type_img }}" alt="{{ $type }}" class="img-responsive">
                                        </figure>
                                        <div class="col-xs-10 col-sm-9">
                                            <h1 class="h3" style="margin-top: 0; font-size: 1.5em;">{{ $type }}</h1>
                                            <p class="text-success">
                                                {{ $audiences->implode('name', ', ') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                                <div cl>
                                    
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-5">
                                    <div class="row">
                                        <figure class="col-xs-2 col-sm-3 col-md-2">
                                            <img src="/assets/img/proposal/ciudades.png" alt="Ciudades" class="img-responsive">
                                        </figure>
                                        <div class="col-xs-10 col-sm-9 col-md-10">
                                            <h1 class="h3" style="margin-top: 0; font-size: 1.5em;">Ciudades</h1>
                                            <p class="text-success">
                                                {{ $proposal->cities->implode('name', ', ') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-offset-1 col-md-5">
                                    <div class="row">
                                        <figure class="col-xs-2 col-sm-3 col-md-2">
                                            <img src="/assets/img/proposal/intereses.png" alt="Escenarios de impacto" class="img-responsive">
                                        </figure>
                                        <div class="col-xs-10 col-sm-9 col-md-10">
                                            <h1 class="h3" style="margin-top: 0; font-size: 1.5em;">Escenarios de impacto</h1>
                                            <p class="text-success">
                                                {{ $proposal->impactScenes->implode('name', ', ') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div id="tab-quote" class="tab-pane">
                    <div class="panel-body">
                        <div class="col-xs-12" id="space-description">
                            @foreach($proposal->quote->questions as $question)
                                <div class="col-xs-6 col-md-4">   
                                    <h4 style="font-weight: 300">{{ $question->text }}</h3>
                                    <h3> <strong> {{ $question->pivot->answer }} </strong></h4>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>

    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>Espacios de Pauta / <span class="text-info">{{ $proposal->spaces->count() }} espacios</span> </h5>
        </div>
        <div class="ibox-content">
            @include('admin.proposals.table-spaces')
        </div>
     </div>

     @include('admin.proposals.modals.space')
     @include('admin.proposals.modals.advertiser')
     @include('admin.proposals.modals.discount')
     @include('admin.proposals.modals.edit')

     @include('admin.publishers.modals.edit-data-contact')
     @include('admin.advertisers.modals.edit-data-detail')

     @include('admin.advertisers.modal-contact')

@endsection

@section('extra-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>

    <script src="/assets/js/plugins/switchery/switchery.min.js"></script>

    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- blueimp gallery -->
    <script src="/assets/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
    <script src="/assets/js/plugins/number/jquery.number.min.js"></script>

    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/advertiserService.js"></script>
    <script src="/assets/js/services/publisherService.js"></script>
    <script src="/assets/js/services/spaceService.js"></script>
    <script src="/assets/js/services/proposal/quoteService.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // PublisherService.drawShowPrices();
            
            SpaceService.initProposal($('#proposal').attr('data-datatable'));
            QuoteService.initProposal();
            
            $('.advertisr-chosen-select').chosen({width: "100%"});
        });
    </script>
@endsection