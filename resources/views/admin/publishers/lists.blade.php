@extends('layouts.admin')

@section('action')
    <ul class="nav navbar-top-links navbar-right  ">
        @include('admin.users.notifications')
        <li style="vertical-align:middle;">
            @if($directContact)
                <button class="btn btn-success" id="form-start-direct-contact" data-url="{{ route('config-modules.start') }}" data-start=0>
                    <i class="fa fa-power-off"> </i> Contacto Directo
                </button>
            @else
                <button class="btn btn-danger" id="form-start-direct-contact" data-url="{{ route('config-modules.start') }}" data-start=1>
                    <i class="fa fa-power-off"> </i> Contacto Directo
                </button>
            @endif
            <button class="btn btn-primary" id="create-publisher"><i class="fa fa-plus"> </i> Crear Medio</button>
        </li>
    </ul>

    @endsection

    @section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers') !!}
    @endsection

    @section('extra-css')

            <!-- Default -->
    <link href="/assets/css/prueba.css" rel="stylesheet">

    <!-- Switchery -->
    <link href="/assets/css/plugins/switchery/switchery.min.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

    <!-- Include Date Range Picker -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

    <style type="text/css">
        .table-state .btn-circle {
            width:24px; height: 24px; padding: 2px 0; font-size: 10px;
        }
    </style>

@endsection

@section('content')
    <div class="col-md-12 list-publisher" id="urlSearch">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group" id="data_created_at">
                            <label class="control-label">Fecha de registro inicial</label>
                            <div class="input-daterange input-group" id="datepicker_created_at_start" data-column="1">
                                <input type="text" class="input-sm form-control" id="created_at_start" name="created_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" id="created_at_end" name="created_at_end"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        {!! Field::select('registration_states', $registrationStates, ['empty' => 'Ver Todos']) !!}
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group" id="data_created_at">
                            <label class="control-label">Fecha de firma de acuerdo</label>
                            <div class="input-daterange input-group" id="datepicker_agreement" data-column="13">
                                <input type="text" class="input-sm form-control" id="agreement_at_start" name="agreement_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" id="agreement_at_end" name="agreement_at_end"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        {!! Field::select('with_spaces', $cities, ['empty' => 'Todas las ciudades']) !!}
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group" id="data_offer_at">
                            <label class="control-label">Fecha de última oferta</label>
                            <div class="input-daterange input-group" id="datepicker_offer" data-column="14">
                                <input type="text" class="input-sm form-control" id="offer_at_start" name="offer_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" id="offer_at_end" name="offer_at_end"/>
                            </div>
                        </div>
                    </div>

                    {{--  <div class="col-lg-3 col-md-4 col-sm-6">
                         <div class="form-group" id="data_last_login_at">
                             <label class="control-label">Fecha de último login</label>
                             <div class="input-daterange input-group" id="datepicker">
                                 <input type="text" class="input-sm form-control" id="last_login_at_start" name="last_login_at_start"/>
                                 <span class="input-group-addon">a</span>
                                 <input type="text" class="input-sm form-control" id="last_login_at_end" name="last_login_at_end"/>
                             </div>
                         </div>
                     </div> --}}

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

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        {!! Field::select('has_logo', ['' => 'Ver Todos', 'true' => 'Si', 'false' => 'No'], ['empty' => 'Ver Todos', 'label' => 'Con Logo']) !!}
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-6">
                        {!! Field::select('tag_id', $tags, ['empty' => 'Todos los tags', 'required', 'label' => 'Tags']) !!}
                    </div>

                </div>

                <div class="table-responsive">
                    <table id="publishers-datatable" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                        <thead>
                        <tr class="info">
                            <th></th>
                            <th>Registro</th>
                            <th>Empresa</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Ofertas</th>
                            <th>Sesi.</th>
                            <th>Contactos</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Registro</th>
                            <th>Empresa</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Ofertas</th>
                            <th>Sesi.</th>
                            <th>Contactos</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.publishers.modal')
    @include('admin.publishers.modal-create')
    @include('admin.publishers.modal-contact')

    @include('admin.publishers.modals.edit-data-contact')
    @include('admin.publishers.modals.edit-data-detail')
    @include('admin.publishers.modals.edit-data-agreement')

    @endsection

    @section('extra-js')

            <!-- iCheck -->
    <script src="/assets/js/plugins/iCheck/icheck.min.js"></script>

    <!-- Switchery -->
    <script src="/assets/js/plugins/switchery/switchery.min.js"></script>

    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Include Required Prerequisites -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

    <!-- Include Date Range Picker -->
    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/publisherService.js"></script>

    <script>
        $(document).ready(function () {

            var filter = $("<strong></strong>")
                    .text(" - Total filtro: ")
                    .addClass("text-success")
                    .append($("<span id='countDatatable'></span>"));

            $(".page-heading h2").append(filter);

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            $("#newContact").click(function(){
                $("#publisherContactModal").modal();
                $("#publisherContactModal input").val("");
                $("#publisherContactModal textarea").val("");
            });

            $('.datetimepicker').datetimepicker({
                format: 'YYYY-MM-DD hh:mm A'
            });

            $("#create-publisher").click(function(){
                $("#publisherCreateModal").modal();
            });

            $("#form-create-publisher").click(function() {
                var url = $(this).attr('data-url');

                var parameters = {
                    'name':         $("#modal_name").val(),
                    'cel':          $("#modal_cel").val(),
                    'email':        $("#modal_email").val(),
                    'company':      $("#modal_company").val(),
                    'action[id]':   $("#modal_publisher_contact_action_id").val(),
                    'action[action_at]': $("#modal_publisher_contact_action_date").val(),
                    'comments':     $("#modal_publisher_contact_comments").val(),
                    '_token':       $("#csrf_token").val()
                };

                swal({
                            title: '¿Estás seguro?',
                            text: 'El medio será creado',
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
                                    $("#publisherCreateModal input").val("");
                                    $("#publisherCreateModal textarea").val("");

                                    if(data.success) {
                                        swal({
                                            "title": "Medio creado",
                                            "type": "success",
                                            closeOnConfirm: true,
                                        });
                                        PublisherService.reload();
                                        $('#publisherCreateModal').modal('toggle');
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
                                            "title": "El medio ya existe",
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

            $("#form-create-contact-publisher").click(function() {
                var url = $('#userModal #newContact').attr('data-url');
                console.log(url);

                var parameters = {
                    'action[id]':           $("#modal_contact_action_id").val(),
                    'action[action_at]':    $("#modal_contact_action_date").val(),
                    'comments':             $("#modal_contact_comments").val(),
                    'type':                 $("#modal_contact_type").val()
                };

                $.post(url, parameters, function( data ) {

                    $("#publisherContactModal input").val("");
                    $("#publisherContactModal textarea").val("");

                    if(data.success) {
                        PublisherService.reload();
                        var socialContact = PublisherService.getSocialContact(data.contact);
                        $('#userModal #comments').prepend(socialContact);
                    }
                    else {
                        console.log('error');
                    }
                });
            });

            $("#form-start-direct-contact").click(function() {
                var url = $(this).attr('data-url');
                var start = $(this).attr('data-start');
                var button = $(this);

                var parameters = {
                    'name': 'direct_contact',
                    'start':  start
                };

                console.log(url);
                console.log(parameters);

                $.post(url, parameters, function( data ) {

                    if(data.success) {
                        if(start == 1) {
                            button.attr('data-start', 0);
                            $("#form-start-direct-contact").removeClass('btn-danger').addClass('btn-success');
                        }
                        else {
                            button.attr('data-start', 1);
                            $("#form-start-direct-contact").removeClass('btn-success').addClass('btn-danger');
                        }
                    }
                    else {
                        console.log('error');
                        console.log(data);
                    }
                });
            });

            PublisherService.init('/medios/search');
            $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
            });

            $(".notification-user").click(function() {
                $.get($(this).data('url'), null, function( data ) {
                    if(data.publisher) {
                        PublisherService.drawModal(data.publisher);
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