@extends('layouts.admin')

@section('action')
    

@section('breadcrumbs')
    {!!  Breadcrumbs::render('proposals') !!}
@endsection

@section('extra-css')

@endsection

@section('content')
    <div class="col-md-12 list-proposal" id="urlSearch">
        <div class="ibox">
            <div class="ibox-content">
                @include('admin.proposals.table')
            </div>
        </div>
    </div>

    
@endsection

@section('extra-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
    <script src="/assets/js/services/proposal/quoteService.js"></script>

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