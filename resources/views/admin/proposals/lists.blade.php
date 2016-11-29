@extends('layouts.admin')

@section('action')
    

@section('breadcrumbs')
    {!!  Breadcrumbs::render('proposals') !!}
@endsection

@section('extra-css')
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <style type="text/css">
        .text-right {
            text-align: right;
        }
    </style>
@endsection

@section('content')
    <div class="col-md-12 list-proposal" id="urlSearch">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group" id="data_send_at">
                            <label class="control-label">Fecha de envío</label>
                            <div class="input-daterange input-group" id="datepicker" data-column="1">
                                <input type="text" class="input-sm form-control" id="send_at_start" name="send_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" id="send_at_end" name="send_at_end"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('states', $states, ['empty' => 'Todas las estados', 'label' => 'Estados']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('cities', $cities, ['empty' => 'Todas las ciudades', 'label' => 'Ciudades']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!! Field::select('publishers', $publishers, ['empty' => 'Todos los Medios', 'label' => 'Medios']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('advertisers', $advertisers, ['empty' => 'Todos los Anunciantes', 'label' => 'Anunciantes']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('spaces', $spaces, ['empty' => 'Todos los Espacios', 'label' => 'Espacios']) !!}
                    </div>
                </div>
                <div class="row">

                </div>

                @include('admin.proposals.table')
            </div>
        </div>
    </div>

    
@endsection

@section('extra-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
    <script src="/assets/js/services/proposal/quoteService.js"></script>

    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
    
    <script>
        var filter = $("<strong></strong>")
            .text(" - Total filtro: ")
            .addClass("text-success")
            .append($("<span id='countDatatable'></span>"));

        $(".page-heading h2").append(filter);
        
        $(document).ready(function() {
            QuoteService.init('/propuestas/search');
        });
    </script>

@endsection