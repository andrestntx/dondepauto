@extends('layouts.admin')

@section('action')
    <a href="{{ route('espacios.create') }}" class="btn btn-primary"><i class="fa fa-plus"> </i> Crear Espacio</a>
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('spaces') !!}
@endsection

@section('extra-css')

@endsection

@section('content')
    <div class="col-md-12 list-space" id="urlSearch">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12" id="table-intro">
                        <div class="col-sm-2">
                            <p class="h4" style="font-size: 20px;">Total: <span id="countDatatable"></span></p>  
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
                <div class="table-responsive">
                    <table id="spaces-datatable" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                        <thead>
                        <tr class="info">
                            <th></th>
                            <th>Medio</th>
                            <th>Espacio</th>
                            <th>Categoría</th>
                            <th>Sub_categoría</th>
                            <th>Formato</th>
                            <th title="Comisión"> % </th>
                            <th>$_Mínimo</th>
                            <th>Markup</th>
                            <th>$_Markup</th>
                            <th>$_Público</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Medio</th>
                            <th>Espacio</th>
                            <th>Categoría</th>
                            <th>Sub categoría</th>
                            <th>Formato</th>
                            <th title="Comisión">.%.</th>
                            <th>$ Mínimo</th>
                            <th>Markup</th>
                            <th>$ Markup</th>
                            <th>$ Público</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.spaces.modal')
@endsection

@section('extra-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>

    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/spaceService.js"></script>
    <script>
        $(document).ready(function() {
            SpaceService.init('/espacios/search');
        });
    </script>

    <script type="text/javascript">

        function changeSelects(inputs) {
            if(inputs.sub_categories) {
                $('#sub_categories option:gt(0)').remove();
                $.each(inputs.sub_categories, function(value,text) {
                    $('#sub_categories').append(
                        $("<option></option>").attr("value", value).text(text)
                    );
                }); 
                UserService.cleanColumnSearch(12);
            }

            if(inputs.publishers) {
                $('#publishers option:gt(0)').remove();
                $.each(inputs.publishers, function(value,text) {
                    $('#publishers').append(
                        $("<option></option>").attr("value", value).text(text)
                    );
                });  
                UserService.cleanColumnSearch(14);
            }

            if(inputs.cities) {                
                $('#cities option:gt(0)').remove();
                $.each(inputs.cities, function(value,text) {
                    $('#cities').append(
                        $("<option></option>").attr("value", value).text(text)
                    );
                }); 
                UserService.cleanColumnSearch(15);
            }

            if(inputs.formats) {
                $('#formats').removeAttr("disabled");
                $('#formats option:gt(0)').remove();
                $.each(inputs.formats, function(value,text) {
                    $('#formats').append(
                        $("<option></option>").attr("value", value).text(text)
                    );
                }); 
                UserService.cleanColumnSearch(13); 
            }
            else if(! $("#sub_categories").val()) { 
                $('#formats').attr('disabled','disabled');
            }
        }

        $("#categories").on('change', function () {
            var parameters = {
                'category': $("#categories").val()
            };

            $.get("/espacios/ajax", parameters, function( data ) {
                if(data.success) {
                    changeSelects(data.inputs);
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
                    changeSelects(data.inputs);
                }
            });
        });

    </script>
@endsection