@extends('layouts.admin')

@section('action')
    <ul class="nav navbar-top-links navbar-right  ">
        @include('admin.users.notifications')
        <li style="vertical-align:middle;">
            <button class="btn btn-primary" id="create-advertiser"><i class="fa fa-plus"> </i> Crear Anunciante</button>    
        </li>
    </ul>
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('advertisers') !!}
@endsection

@section('extra-css')
    <link href="/assets/css/prueba.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <!-- Include Date Range Picker -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <style type="text/css">
        .table-state .btn-circle {
            width:24px; height: 24px; padding: 2px 0; font-size: 10px;
        }
        .list-advertiser .text-center.table-state {
            margin: 0 2px;
        }
    </style>
@endsection

@section('content')
    <div class="col-md-12 list-advertiser" id="urlSearch">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group" id="data_created_at">
                            <label class="control-label">Fecha de registro</label>
                            <div class="input-daterange input-group" id="datepicker" data-column="1">
                                <input type="text" class="input-sm form-control" id="created_at_start" name="created_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" id="created_at_end" name="created_at_end"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        {!! Field::select('registration_states', $registrationStates, ['empty' => 'Todos']) !!}
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group" id="intention_created_at">
                            <label class="control-label">Fecha de Leads</label>
                            <div class="input-daterange input-group" id="datepicker" data-column="16">
                                <input type="text" class="input-sm form-control" id="intention_at_start" name="intention_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" id="intention_at_end" name="intention_at_end"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        {!! Field::select('cities', $cities, ['empty' => 'Todas las ciudades']) !!}
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        {!! Field::select('economic_activities', $economicActivities, ['empty' => 'Todas las Actividades']) !!}
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label class="control-label" style="display: block;">Actividades Pendientes</label>
                            <div class="btn-group" role="group" aria-label="Large button group">
                                <button type="button" class="btn btn-white active" data-action="0">Todas</button>
                                @foreach($actions as $action)
                                    <button type="button" class="btn btn-white" data-action="{{ $action->id }}" title="{{ $action->name }}" data-toggle="tooltip" data-placement="bottom"><i class="{{ $action->logo }}"></i></button>
                                @endforeach
                            </div>  
                        </div>  
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label class="control-label" style="display: block;">Fecha de Actividades</label>
                            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                                <span></span> <b class="caret"></b>
                            </div>
                        </div>
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
                            <th>Int.</th>
                            <th>Sesi.</th>
                            <th>Esp.</th>
                            <th>Contactos</th>
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
                            <th>Int.</th>
                            <th>Sesi.</th>
                            <th>Esp.</th>
                            <th>Contactos</th>
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

    @include('admin.publishers.modals.edit-data-contact')
    @include('admin.advertisers.modals.edit-data-detail')
@endsection

@section('extra-js')

    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/advertiserService.js"></script>

    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

     <!-- Include Required Prerequisites -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    
    <script>
        var filter = $("<strong></strong>")
            .text(" - Total filtro: ")
            .addClass("text-success")
            .append($("<span id='countDatatable'></span>"));

        $(".page-heading h2").append(filter);

        $(document).ready(function() {

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

            
            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD hh:mm A'
            });

            $("#form-create-advertiser").click(function() {
                var url = $(this).attr('data-url');

                var parameters = {
                    'name':         $("#modal_name").val(),
                    'cel':          $("#modal_cel").val(),
                    'email':        $("#modal_email").val(),
                    'company':      $("#modal_company").val(),
                    'action[id]':   $("#modal_advertiser_contact_action_id").val(),
                    'action[action_at]': $("#modal_advertiser_contact_action_date").val(),
                    'comments':     $("#modal_advertiser_contact_comments").val(),
                    '_token':       $("#csrf_token").val()
                };

                swal({
                    title: '¿Estás seguro?',
                    text: 'El anunciante será creado',
                    type: "warning",
                    confirmButtonText: "Confirmar",
                    confirmButtonColor: "#18A689",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    html: true
                },
                function(isConfirm) {
                    if (isConfirm) {    
                        $.post(url, parameters, function( data ) {
                            $("#advertiserCreateModal input").val("");
                            $("#advertiserCreateModal textarea").val("");

                            if(data.success) {
                                swal({
                                    "title": "Anunciante creado", 
                                    "type": "success",
                                    closeOnConfirm: true,
                                });
                                AdvertiserService.reload();
                                $('#advertiserCreateModal').modal('toggle');
                            }
                            else {
                                swal({
                                    "title": "Hubo un error", 
                                    "type": "warning",
                                    closeOnConfirm: true,
                                });
                            }
                        }).fail(function(data) {
                            if(data.status == 422) {
                                swal({
                                    "title": "El anunciante ya existe", 
                                    "type": "warning",
                                    closeOnConfirm: true,
                                });    
                            }
                            else {
                                swal({
                                    "title": "Hubo un error", 
                                    "type": "warning",
                                    closeOnConfirm: true,
                                });
                            }
                            
                        });
                    }
                });
            });

            $("#form-create-contact-advertiser").click(function() {
                var url = $('#userModal #newContact').attr('data-url');
                console.log(url);

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
                        var socialContact = AdvertiserService.getSocialContact(data.contact);
                        $('#userModal #comments').prepend(socialContact);
                    }
                    else {
                        console.log('error');
                    }
                });
            });

            AdvertiserService.init('/anunciantes/search');

            $(".notification-user").click(function() { 
                $.get($(this).data('url'), null, function( data ) {
                    if(data.advertiser) {
                        AdvertiserService.drawModal(data.advertiser);
                    }
                    else {
                        swal("Hubo un error", "", "danger");
                    }
                }).fail(function(){
                    swal("Hubo un error", "", "danger");
                });
            });
        });
    </script>
@endsection