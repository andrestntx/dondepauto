@extends('layouts.publisher-datatable')

@section('extra-css')
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <style type="text/css">
        .text-right {
            text-align: right;
        }

        .sum_total_proposal {
            padding-top: 3.5em;
        }

        .sum_total_proposal p {
            font-size: 1.6em;
            color: gray;
            font-weight: 200;
        }

        .sum_total_proposal p span{
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="dashboard">
        <div class="row">
            <div class="col-xs-12">
                <div class="wrapper wrapper-content animated fadeIn">
                    <div class="row">
                        <div class="inbox">
                            <div class="inbox-content">
                                <div class="col-sm-2 col-xs-6">
                                    {!!  Breadcrumbs::render('proposals') !!}
                                </div>
                                <div class="col-sm-2 col-xs-6 sum_total_proposal">
                                    <p># Propuestas: <span id="total_proposals"></span> </p>
                                </div>
                                <div class="col-sm-4 col-xs-6 sum_total_proposal">
                                    <p>$ Propuestas: <span id="total_price_proposals"></span> </p>
                                </div>
                                <div class="col-sm-4 col-xs-6 sum_total_proposal">
                                    <p>$ Incentivo: <span id="total_income_proposals"></span> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wrapper wrapper-content animated fadeIn">
                    <div class="row">
                        <div class="col-md-12 list-proposal" id="urlSearch">
                            <div class="ibox">
                                <div class="ibox-content">
                                    
                                    <div class="row">

                                    </div>

                                    @include('admin.proposals.table')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
        $(document).ready(function() {
            QuoteService.init('proposals/search');
        });
    </script>

@endsection