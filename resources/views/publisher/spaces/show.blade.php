@extends('layouts.simple')

@section('extra-css')
    <link href="/assets/css/plugins/slick/slick.css" rel="stylesheet">
    <link href="/assets/css/plugins/slick/slick-theme.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <style type="text/css">
        .space-item {
            margin-top: 11px;
        }

        .space-item-title {
            font-size: 1.2em;
            font-weight: 700;
        }

        .space-item-text {
            font-size: 1.1em;
            font-weight: 500;
        }

        .space-title {
            font-size: 2.3em;
            font-weight: bold;
            margin-top: 0;
        }

        h2.product-main-price {
            font-size: 2.3em;
            font-weight: 400;
        }

        h2.product-main-price small.text-muted {
            font-size: 0.6em;
        }

        a#marketplace {
            float: right;
        }

        hr.space-item-separator {
            border-top: 3px solid rgba(199, 199, 199, 0.73);
            margin-top: 15px;
        }

        .space-options a {
            margin-right: 10px;
        }

        .space-images .slick-prev {
            left: -35px;
        }

        .space-images .slick-prev:before, .slick-next:before {
            font-family: 'slick';
            font-size: 30px;
            line-height: 1;
            opacity: .75;
            color: white;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .space-images .slick-dots li button:before {
            font-family: 'slick';
            font-size: 9px;
            line-height: 20px;
            position: absolute;
            top: 0;
            left: 0;
            width: 20px;
            height: 20px;
            content: '•';
            text-align: center;
            opacity: .25;
            color: #595d5f;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .space-images .slick-prev:before, .slick-next:before {
            color: #23C6C8 !important;
        }

        .space-images .slick-dots li.slick-active button:before {
            opacity: .75;
            color: #676769;
        }

    </style>
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')
    <div class="se-pre-con"></div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox product-detail">
                    <div class="col-md-5" style="margin-top: 10px;">
                        <div class="product-images space-images">
                            @foreach($space->images as $image)
                                <div>
                                    <div class="image">
                                        <img src="{{ $image->url }}">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h2 class="font-bold m-b-xs space-title">
                            {{ $space->name }}
                        </h2>

                        <div class="row">
                            <div class="col-md-6">
                                    <h2 class="product-main-price"> ${{ number_format($space->minimal_price, 0, ',', '.') }} / <small class="text-muted"> {{ $space->period }}</small> </h2>
                            </div>

                            <div class="col-md-6 m-t-md">
                                <a class="btn btn-warning" target="_blank" id="marketplace" href="{{ $space->url_marketplace }}"><i class="fa fa-eye"></i> VER EN MARKETPLACE</a>
                            </div>
                        </div>
                        
                        <hr class="space-item-separator">

                        <h4 class="space-item-title">Descripción</h4>
                        <div class="small text-muted space-item-text">
                            {!! $space->description !!}
                        </div>

                        <div class="row space-item">
                            <div class="col-md-4 space-item-title">
                                Categoría
                            </div>
                            <div class="col-md-8 space-item-text">
                                {{ $space->getCategory()->name }}
                            </div>
                        </div>

                        <div class="row space-item">
                            <div class="col-md-4 space-item-title">
                                SubCategoría
                            </div>
                            <div class="col-md-8 space-item-text">
                                {{ $space->subCategory->name }}
                            </div>
                        </div>

                        <div class="row space-item">
                            <div class="col-md-4 space-item-title">
                                Formato
                            </div>
                            <div class="col-md-8 space-item-text">
                                {{ $space->format->name }}
                            </div>
                        </div>

                        <div class="row space-item">
                            <div class="col-md-4 space-item-title">
                                Dimensiones
                            </div>
                            <div class="col-md-8 space-item-text">
                                {{ $space->dimension }}
                            </div>
                        </div>

                        <div class="row space-item">
                            <div class="col-md-4 space-item-title">
                                Impacto estimado
                            </div>
                            <div class="col-md-8 space-item-text">
                                {{ $space->impact }}
                            </div>
                        </div>

                        <div class="row space-item">
                            <div class="col-md-4 space-item-title">
                                Escenarios de impacto
                            </div>
                            <div class="col-md-8 space-item-text">
                                @foreach($space->impactScenes as $scene)
                                    {{ $space->format->name }} ,
                                @endforeach
                            </div>
                        </div>
                        
                        <hr class="space-item-separator">

                        <div class="space-options">
                            <a href="{{ route('medios.espacios.edit', [$publisher, $space]) }}" class="btn btn-info"><i class="fa fa-pencil"></i> EDITAR OFERTA</a>
                            <a href="/" class="btn btn-danger"><i class="fa fa-trash"></i> BORRAR</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <!-- slick carousel-->
    <script src="/assets/js/plugins/slick/slick.min.js"></script>

    <script>
        $('.product-images').slick({
            dots: true
        });

        $(document).ready(function(){
            
        });
    </script>
@endsection