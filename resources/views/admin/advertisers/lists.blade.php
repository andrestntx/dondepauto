@extends('layouts.admin')

@section('action')
   <button class="btn btn-primary" id="create-advertiser"><i class="fa fa-plus"> </i> Crear Anunciante</button>
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('advertisers') !!}
@endsection

@section('extra-css')
    <link href="/assets/css/prueba.css" rel="stylesheet">
@endsection

@section('content')
    <div class="col-md-12 list-advertiser" id="urlSearch">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12" id="table-intro">
                        <div class="col-sm-2">
                            <p class="h4" style="font-size: 20px;">Total: <span id="countDatatable">0</span></p>  
                        </div>
                        <div class="col-sm-10 timeline">
                            <div class="linea"></div>
                            <div class="states-table">
                                <div class="state text-center">
                                    <button type="button" class="steps-img btn-circle btn btn-default"><i class="fa fa-child"></i></button>
                                    <p class="steps-name">Registro inicial</p>
                                </div>
                                <div class="state text-center">
                                    <button type="button" class="steps-img btn-circle btn btn-default"><i class="fa fa-envelope"></i></button>
                                    <p class="steps-name">Validación de email</p>
                                </div><div class="state text-center">
                                    <button type="button" class="steps-img btn-circle btn btn-default"><i class="fa fa-edit"></i></button>
                                    <p class="steps-name">Complementario</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" id="data_created_at">
                            <label class="control-label">Fecha de registro</label>
                            <div class="input-daterange input-group" id="datepicker" data-column="1">
                                <input type="text" class="input-sm form-control" id="created_at_start" name="created_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" id="created_at_end" name="created_at_end"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('registration_states', $registrationStates, ['empty' => 'Todos']) !!}
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" id="intention_created_at">
                            <label class="control-label">Fecha de Leads</label>
                            <div class="input-daterange input-group" id="datepicker" data-column="14">
                                <input type="text" class="input-sm form-control" id="intention_at_start" name="intention_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" id="intention_at_end" name="intention_at_end"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!! Field::select('cities', $cities, ['empty' => 'Todas las ciudades']) !!}
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('economic_activities', $economicActivities, ['empty' => 'Todas las Actividades']) !!}
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="advertisers-datatable" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                        <thead>
                        <tr class="info">
                            <th></th>
                            <th>Registro</th>
                            <th>Empresa</th>
                            <th>Ciudad</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Celular</th>
                            <th>Estado</th>
                            <th>Inten.</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Empresa</th>
                            <th>Registro</th>
                            <th>Ciudad</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Celular</th>
                            <th>Estado</th>
                            <th>Inten.</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.advertisers.modal')
    @include('admin.advertisers.modal-create')
    @include('admin.advertisers.modal-contact')
@endsection

@section('extra-js')

    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/advertiserService.js"></script>
    <script>
        $(document).ready(function() {
            AdvertiserService.init('/anunciantes/search');

            $("#create-advertiser").click(function(){
                $("#advertiserCreateModal").modal();
            });

            $("#newContact").click(function(){
                $("#advertiserContactModal").modal();
                $("#advertiserContactModal input").val("");
                $("#advertiserContactModal textarea").val("");
            });

            $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
            });

            $("#form-create-advertiser").click(function() {
                var url = $(this).data('url');
                var parameters = {
                    'name':         $("#modal_name").val(),
                    'cel':          $("#modal_cel").val(),
                    'email':        $("#modal_email").val(),
                    'company':      $("#modal_company").val(),
                    'action[id]':   $("#modal_action_id").val(),
                    'action[action_at]': $("#modal_action_date").val(),
                    'comments':     $("#modal_comments").val(),
                    '_token':       $("#csrf_token").val()
                };

                $.post(url, parameters, function( data ) {
                    console.log(data);
                    $("#advertiserCreateModal input").val("");
                    $("#advertiserCreateModal textarea").val("");

                    if(data.success) {
                        AdvertiserService.reload();
                    }
                    else {
                        console.log('error');
                    }
                });
            });

            $("#form-create-contact-advertiser").click(function() {
                var url = $('#advertiserModal #newContact').data('url');

                var parameters = {
                    'action[id]':           $("#modal_contact_action_id").val(),
                    'action[action_at]':    $("#modal_contact_action_date").val(),
                    'comments':             $("#modal_contact_comments").val(),
                    '_token':               $("#contact_csrf_token").val()
                };

                $.post(url, parameters, function( data ) {

                    $("#advertiserContactModal input").val("");
                    $("#advertiserContactModal textarea").val("");

                    if(data.success) {
                        AdvertiserService.reload();
                    }
                    else {
                        console.log('error');
                    }
                });
            });
        });
    </script>
@endsection