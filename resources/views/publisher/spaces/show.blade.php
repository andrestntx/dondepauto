@extends('layouts.simple')

@section('extra-css')
    <link href="/assets/css/plugins/slick/slick.css" rel="stylesheet">
    <link href="/assets/css/plugins/slick/slick-theme.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <style type="text/css">

        .space-item-title {
            font-size: 1.1em;
            font-weight: bold;
            color: gray;
            margin: 0.5em 0;
        }

        .space-item-text {
            font-size: 1.1em;
            font-weight: 500;
            display: block;
            padding-left: 0;
            color: rgb(103, 106, 108);
            margin-top: 0.1em;
        }

        .space-title {
            font-size: 2.3em;
            font-weight: bold;
            margin-top: 0;
        }

        .space-item-text p {
            font-size: 1em;
        }

        .tag {
            border: 1px solid rgba(128, 128, 128, 0.54);
            padding: 0.2em 0.4em;
            margin: 0.2em;
            float: left;
        }

        span.restriction {
            border: 1px solid rgba(244, 67, 54, 0.52);
            padding: 0.2em 0.4em;
            margin: 0.2em;
            float: left;
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

        .space-item-title.space-item-group {
            color: #4182f2;
            font-size: 1.4em;
            font-weight: 600;
            border-bottom: 2px solid rgba(128, 128, 128, 0.43);
            padding-left: 0;
            padding-bottom: 0.1em;
            margin-top: 0.5em;
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

                        <div class="row space-item">
                            <div class="col-xs-12 space-item-title space-item-group">
                                Información de precios
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 space-item-title">
                                Descuento máximo para cliente
                                <span class="space-item-text"> {{ $space->discount }}% </span>
                            </div>
                        
                            <div class="col-sm-6 space-item-title">
                                Precio mínimo de Venta
                                <span class="space-item-text"> ${{ number_format($space->prices_minimal_price, 0, ',', '.') }} </span>
                            </div>

                            <div class="col-sm-6 space-item-title">
                                Precio de Oferta al Público
                                <span class="space-item-text"> ${{ number_format($space->minimal_price, 0, ',', '.') }} </span>
                            </div>

                        </div>

                        <div class="row space-item">
                            <div class="col-xs-12 space-item-title space-item-group">
                                Información básica
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 space-item-title">
                                Categoría
                                <span class="space-item-text"> {{ $space->getCategory()->name }} </span>
                            </div>
                        
                            <div class="col-sm-6 space-item-title">
                                SubCategoría
                                <span class="space-item-text"> {{ $space->subCategory->name }} </span>
                            </div>
                        
                            <div class="col-sm-6 space-item-title">
                                Formato
                                <span class="space-item-text"> {{ $space->format->name }} </span>
                            </div>

                            <div class="col-sm-6 space-item-title">
                                Dimensiones
                                <span class="space-item-text"> {{ $space->dimension }} </span>
                            </div>
                        </div>

                        <div class="row space-item">
                            <div class="col-xs-12 space-item-title space-item-group">
                                Audiencias
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 space-item-title">
                                Escenarios de impacto
                                <span class="space-item-text"> {{ $space->impactScenes->implode('name', ', ') }} </span>
                            </div>

                            <div class="col-sm-12 space-item-title">
                                Ciudades
                                <span class="space-item-text"> {{ $space->cities->implode('name', ', ') }} </span>
                            </div>

                            <div class="col-sm-6 space-item-title">
                                Impacto estimado
                                <span class="space-item-text"> {{ $space->impact }} por {{ $space->period }}</span>
                            </div>

                            @foreach($space->audiences->groupBy('type_name') as $type => $audiences)
                                <div class="col-sm-6 space-item-title">
                                    <span>{{ $type }}</span>
                                    <span class="space-item-text"> {{ $audiences->implode('name', ', ') }} </span>
                                </div>
                            @endforeach 
                        </div>

                        @if($space->alcohol_restriction || $space->snuff_restriction || $space->policy_restriction  || $space->sex_restriction)
                            <div class="row space-item">
                                <div class="col-xs-12 space-item-title space-item-group" style="color: rgba(244, 67, 54, 0.74);">
                                    Restricciones de categoría en la pauto
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-10 space-item-title">
                                    <span class="space-item-text"> 
                                        @if($space->alcohol_restriction)
                                            <span class="restriction">Alcohol</span>
                                        @endif

                                        @if($space->snuff_restriction)
                                            <span class="restriction">Tabaco</span>
                                        @endif

                                        @if($space->policy_restriction)
                                            <span class="restriction">Política</span>
                                        @endif

                                        @if($space->sex_restriction)
                                            <span class="restriction">Sexo</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @endif

                        <div class="row space-item">
                            <div class="col-xs-12 space-item-title space-item-group">
                                Descripción
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 space-item-title">
                                <span class="space-item-text"> 
                                    {!! $space->description !!}  
                                </span>
                            </div>
                        </div>

                        <div class="row space-item">
                            <div class="col-xs-12 space-item-title space-item-group">
                                Etiquetas
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10 space-item-title">
                                <span class="space-item-text"> 
                                    @foreach(explode(',', $space->more_audiences) as $tag)
                                        <div class="tag"> {{ $tag }} </div>
                                    @endforeach
                                </span>
                            </div>
                        </div>
                        
                        <hr class="space-item-separator">

                        <div class="space-options">
                            <a href="{{ route('medios.espacios.edit', [$publisher, $space]) }}" class="btn btn-info"><i class="fa fa-pencil"></i> EDITAR OFERTA</a>
                            <button id="btn-delete" class="btn btn-danger" data-url="{{ route('medios.espacios.destroy', [$publisher, $space]) }}" data-reload="{{ route('medios.espacios.index', $publisher) }}" style="display: inline-block;">
                                <i class="fa fa-trash"></i> BORRAR
                            </button>
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
    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

    <script>
        $('.product-images').slick({
            dots: true
        });

        $(document).ready(function(){
            $("#btn-delete").click(function() {
                swal({
                    title: '¿Estás seguro?',
                    text: 'El espacio será eliminado',
                    type: "warning",
                    confirmButtonText: "Confirmar",
                    confirmButtonColor: "#FFAC1A",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    html: true
                },
                function(isConfirm) {
                    if (isConfirm) {     
                        $.ajax({
                            url: $("#btn-delete").data('url'),
                            type: 'DELETE',
                            success: function(data) {
                                if(data.success) {
                                    swal({
                                        "title": "Espacio eliminado", 
                                        "type": "success"
                                    },
                                    function() {
                                        window.location.replace($("#btn-delete").data('reload'));
                                    });
                                }
                                else {
                                    swal("Hubo un error", "", "warning");
                                }
                            }
                        });
                    } 
                });
            }); 
        });
    </script>
@endsection