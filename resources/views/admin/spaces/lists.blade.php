@extends('layouts.admin')

@section('action')
    {{-- <a href="{{ route('espacios.create') }}" class="btn btn-primary"><i class="fa fa-plus"> </i> Crear Espacio</a> --}}
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('spaces') !!}
@endsection

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

@section('content')
    <div class="col-md-12 list-space" id="urlSearch">
        <div class="ibox" id="search-space" data-search="{{ $spaceId }}">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        {!! Form::select('avtive_state', ['' => 'Todos', '1' => 'Activos', '0' => 'Inactivos'], null, ['empty' => 'Ver Todos', 'class' => 'form-control', 'id' => 'active_state']) !!}
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        {!! Field::select('categories', $categories, ['empty' => 'Ver Todas']) !!}
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        {!! Field::select('sub_categories', $subCategories, ['empty' => 'Ver Todas']) !!}
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        {!! Field::select('formats', ['' => ''], ['empty' => 'Ver Todos', 'disabled']) !!}
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        {!! Field::select('cities', $cities, ['empty' => 'Todas las ciudades']) !!}
                    </div>
                    <div class="col-md-3 col-sm-6">
                        {!! Field::select('publishers', $publishers, ['empty' => 'Todos los Medios']) !!}
                    </div>
                    <div class="col-md-3 col-sm-6">
                        {!! Field::select('scenes', $scenes, ['empty' => 'Todas los escenarios']) !!}
                    </div>
                    <div class="col-md-3 col-sm-6">
                        {!! Field::select('tag_id', $tags, ['empty' => 'Todos los tags', 'required', 'label' => 'Tags']) !!}
                    </div>
                </div>
                <div class="row">

                </div>
                
                @include('admin.spaces.table')
            </div>
        </div>
    </div>

    @include('admin.spaces.modal')
    @include('admin.spaces.modals.suggest')
    @include('admin.spaces.modals.proposal')

@endsection

@section('extra-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
    <script src="/assets/js/plugins/switchery/switchery.min.js"></script>
    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/sweetalert2/4.2.4/sweetalert2.min.js"></script>

    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/spaceService.js"></script>

    <!-- blueimp gallery -->
    <script src="/assets/js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>

    <script>
        var filter = $("<strong></strong>")
            .text(" - Total filtro: ")
            .addClass("text-success")
            .append($("<span id='countDatatable'></span>"));

        $(".page-heading h2").append(filter);
        
        $(document).ready(function() {
            
            var searchSpace = $("#search-space").data("search");
            
            if(searchSpace){
                SpaceService.init('/espacios/search?espacio=' + searchSpace);
            }
            else {
                SpaceService.init('/espacios/search');
            }

            SpaceService.initChangeTag();

            $('.advertisr-chosen-select').chosen({width: "100%"});
            $('.proposal-chosen-select').chosen({width: "100%"});

        });
    </script>

    <script type="text/javascript">

        $("#categories").on('change', function () {
            var parameters = {
                'category': $("#categories").val()
            };

            $.get("/espacios/ajax", parameters, function( data ) {
                if(data.success) {
                    SpaceService.changeSelects(data.inputs, 11, parameters.category);
                }
            });
        } );

    </script>
@endsection