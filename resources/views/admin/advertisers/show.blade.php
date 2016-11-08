@extends('layouts.admin')

@section('extra-css')
    <link href="/assets/css/prueba.css" rel="stylesheet">
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('advertisers.advertiser', $advertiser) !!}
@endsection

@section('content')   
    <div class="col-sm-12 m-b-md" id="advertiser" data-advertiser="{{ $advertiser }}" data-datatable="{{ route('anunciantes.propuestas.search', $advertiser) }}">
        <div class="ibox-title">
            <h5>Detalle del Anunciante - Total Propuestas ({{ count($proposals) }})</h5>
            <div class="ibox-tools">
                <a class="btn btn-sm btn-warning" data-toggle="tooltip" title="Editar Anunciante" href="{{ route('anunciantes.edit', $advertiser) }}">
                    <i class="fa fa-pencil"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-4">   
                    <p>
                        <span class="h5 font-bold"> Contacto </span> <br>
                        <span class="h5"> {{ $advertiser->name }} </span> <br>
                        <span class="h5"> {{ $advertiser->company_role }} - {{ $advertiser->company_area }} </span> <br>
                        <span class="h5"> <i class="fa fa-envelope-o"></i> <a href="mailto:{{ $advertiser->email }}"> {{ $advertiser->email }} </a> </span> <br>
                        <span class="h5">   
                            <i class="fa fa-phone"> </i> 
                            <a href="tel:{{ $advertiser->phone }}"> {{ $advertiser->phone }} </a> -
                            <i class="fa fa-mobile"></i> <a href="tel:{{ $advertiser->cel }}"> {{ $advertiser->cel }} </a>
                        </span>
                    </p>
                </div>
                <div class="col-sm-4">
                    <p>
                        <span class="h5 font-bold"> Ubicación </span> <br>
                        <span class="h5"> {{ $advertiser->address }} </span> <br>
                        <span class="h5"> {{ $advertiser->city_name }} </span> <br>
                        <span class="h5"> NIT: {{ $advertiser->company_nit }} </span>
                    </p>
                </div>
                <div class="col-sm-4">
                    <p>
                        <span class="h5 font-bold"> Acuerdo ({{ $advertiser->signed_agreement_lang }}) </span> <br>
                        @if($advertiser->signed_agreement)
                            <span class="h5"> Porcentaje de comisión:  <span class="font-bold"> {{ $advertiser->commission_rate }}% </span> </span> <br>
                            <span class="h5"> Fecha firma de acuerdo:  <span class="font-bold"> {{ $advertiser->signed_at }} </span> </span> <br>
                            <span class="h5"> Descuento pronto pago:   <span class="font-bold"> {{ $advertiser->discount }}% </span> </span> <br>
                            <span class="h5"> Retención en la fuente:  <span class="font-bold"> {{ $advertiser->retention }}% </span> <br>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 m-t-sm">
                    <p>
                        <span class="h5 font-bold"> Descripción actividad </span> <br>
                        <span class="h5"> {{ $advertiser->comments }} </span> <br>
                    </p>
                </div>
                <div class="col-sm-8 m-t-sm list-advertiser">
                   <div class="timeline" id="prueba"> </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>Propuestas</h5>
        </div>
        <div class="ibox-content">
            @include('admin.proposals.table')
        </div>
     </div>

     @include('admin.proposals.modal')

@endsection

@section('extra-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/advertiserService.js"></script>
    <script src="/assets/js/services/proposal/quoteService.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            //AdvertiserService.drawShowPrices();
            QuoteService.init($('#advertiser').data('datatable'));
            //QuoteService.initModalEvent();
        });
    </script>
@endsection