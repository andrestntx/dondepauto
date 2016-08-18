@extends('layouts.admin')

@section('action')
    <a href="{{ route('espacios.create') }}" class="btn btn-primary"><i class="fa fa-plus"> </i> Crear Espacio</a>
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('spaces') !!}
@endsection

@section('extra-css')
    <link href="/assets/css/plugins/switchery/switchery.min.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
@endsection

@section('content')
    <div class="col-md-12 list-space" id="urlSearch">
        <div class="ibox" id="search-space" data-search="{{ $spaceId }}">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12" id="table-intro">
                        <div class="row">
                            <div class="col-sm-4 col-md-2">
                                {!! Form::select('avtive_state', ['' => 'Todos', '1' => 'Activos', '0' => 'Inactivos'], null, ['empty' => 'Ver Todos', 'class' => 'form-control', 'id' => 'active_state']) !!}
                            </div>
                            <div class="col-sm-3 col-md-2">
                                <p class="h4" style="font-size: 20px;">Total: <span id="countDatatable"></span></p>  
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('categories', $categories, ['empty' => 'Ver Todas']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('sub_categories', $subCategories, ['empty' => 'Ver Todas']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('formats', ['' => ''], ['empty' => 'Ver Todos', 'disabled']) !!}
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!! Field::select('cities', $cities, ['empty' => 'Todas las ciudades']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('publishers', $publishers, ['empty' => 'Todos los Medios']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('scenes', $scenes, ['empty' => 'Todas los escenarios']) !!}
                    </div>
                </div>
                <div class="row">

                </div>
                
                @include('admin.spaces.table')
            </div>
        </div>
    </div>

    @include('admin.spaces.modal')
@endsection

@section('extra-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
    <script src="/assets/js/plugins/switchery/switchery.min.js"></script>
    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/spaceService.js"></script>
    <script>
        $(document).ready(function() {
            
            var searchSpace = $("#search-space").data("search");
            
            if(searchSpace){
                SpaceService.init('/espacios/search?espacio=' + searchSpace);
            }
            else {
                SpaceService.init('/espacios/search');
            }

        });
    </script>

    <script type="text/javascript">

        $("#categories").on('change', function () {
            console.log('cambio categoria');

            var parameters = {
                'category': $("#categories").val()
            };

            $.get("/espacios/ajax", parameters, function( data ) {
                if(data.success) {
                    SpaceService.changeSelects(data.inputs);
                }
            });
        } );

        $("#sub_categories, #formats, #cities").on('change', function () {
            var parameters = {
                'sub_category': $("#sub_categories").val(),
                'format': $("#formats").val(),
                'city': $("#cities").val(),
            };

            $.get("/espacios/ajax", parameters, function( data ) {
                if(data.success) {
                    SpaceService.changeSelects(data.inputs);
                }
            });
        });

    </script>
@endsection