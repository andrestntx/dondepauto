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
    <h2>{{ $proposal->title }}</h2>
    <ol class="breadcrumb">
        <li><a href="/propuestas">Propuestas</a></li>
        <li><a href="#">Anunciantes</a></li>
        <li class="active"><strong>{{ ucfirst($advertiser->company) }}</strong></li>
    </ol>
@endsection

@section('action')
    <div style="padding: 1em;">
        <a href="{{ route('proposals.preview-html', $proposal) }}" class="btn btn-success" target="_blank" title="HTML"><i class="fa fa-list-alt"></i></a>
        <a href="{{ route('proposals.preview-pdf', $proposal) }}" class="btn btn-warning" target="_blank" title="PDF"><i class="fa fa-file-pdf-o"></i></a>
        <button class="btn btn-primary" title="Enviar propuesta" id="sendProposal"><i class="fa fa-paper-plane"></i> Enviar propuesta</button>
    </div>
@endsection

@section('content')   
    <div class="col-sm-12 m-b-md" id="proposal" data-advertiser="{{ $advertiser }}" data-states="{{ json_encode($advertiser->states) }}" data-contacts="{{ json_encode($contacts) }}" data-proposal="{{ $proposal }}" data-datatable="{{ route('proposals.spaces.search', $proposal) }}">
        <div class="ibox-title">
            <h5>Detalle de la propuesta: {{ $proposal->title }} / <span class="text-info">{{ $proposal->spaces->count() }} espacios publicitarios</span></h5>
            <div class="ibox-tools">
                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalContacts">
                    <i class="fa fa-history"></i>
                </button>

                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalQuestions">
                    <i class="fa fa-file-text-o"></i>
                </button>
            </div>
        </div>
        <div class="ibox-content proposal-detail">
            <div class="row">
                <div class="col-sm-3">   
                    <p>
                        <span class="h5"> 
                            <span style="font-weight: 200;">Fecha solicitud:</span> 
                            {{ ucfirst($proposal->created_at_date) }} 
                            <button class="btn btn-xs btn-success" id="proposalAdvertiser"><i class="fa fa-user"></i></button>
                        </span> <br>
                        <span class="h5"> 
                            <span style="font-weight: 200;">Razón social:</span> 
                            {{ ucfirst($advertiser->company_legal) }} 
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
                <div class="col-sm-3">
                    <p>
                        <span class="h5 font-bold"> CIFRAS DEL NEGOCIO </span> <br>
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
                <div class="col-sm-3">
                    <p>
                        <span class="h5 font-bold"> DESCUENTOS Y BONIFICADOS </span> <br>
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
                <div class="col-sm-3">
                    <p>
                        <span class="h5"> 
                            <span style="font-weight: 200;">Fecha de envío:</span> 
                            {{ ucfirst($proposal->send_at_date) }} 
                        </span> <br>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>Espacios de Pauta</h5>
        </div>
        <div class="ibox-content">
            @include('admin.proposals.table-spaces')
        </div>
     </div>

     @include('admin.proposals.modals.space')
     @include('admin.proposals.modals.contacts')
     @include('admin.proposals.modals.questions')
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