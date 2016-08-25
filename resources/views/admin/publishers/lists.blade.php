@extends('layouts.admin')

@section('action')
    <a href="{{ route('medios.create') }}" class="btn btn-primary"><i class="fa fa-plus"> </i> Crear Medio</a>
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers') !!}
@endsection

@section('extra-css')
    <link href="/assets/css/plugins/switchery/switchery.min.css" rel="stylesheet">
    <link href="/assets/css/prueba.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
@endsection

@section('content')
    <div class="col-md-12 list-publisher" id="urlSearch">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12" id="table-intro">
                        <div class="col-sm-2">
                            <p class="h4" style="font-size: 20px;">Total: <span id="countDatatable"></span></p>  
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
                                <div class="state text-center">
                                    <button type="button" class="steps-img btn-circle btn btn-default"><i class="fa fa-file-text-o"></i></button>
                                    <p class="steps-name">Firmó acuerdo</p>
                                </div>
                                <div class="state text-center">
                                    <button type="button" class="steps-img btn-circle btn btn-default"><i class="fa fa-tags"></i></button>
                                    <p class="steps-name">Ofertó</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" id="data_created_at">
                            <label class="control-label">Fecha de registro inicial</label>
                            <div class="input-daterange input-group" id="datepicker_created_at_start" data-column="1">
                                <input type="text" class="input-sm form-control" id="created_at_start" name="created_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" id="created_at_end" name="created_at_end"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        {!! Field::select('registration_states', $registrationStates, ['empty' => 'Ver Todos']) !!}
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" id="data_created_at">
                            <label class="control-label"> <input type="checkbox" class="i-checks" id="signed_agreement"> Firma de acuerdo</label>
                            <div class="input-daterange input-group" id="datepicker_agreement" data-column="10">
                                <input type="text" class="input-sm form-control" disabled id="agreement_at_start" name="agreement_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" disabled id="agreement_at_end" name="agreement_at_end"/>
                            </div>
                        </div>
                    </div>                
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!! Field::select('with_spaces', $cities, ['empty' => 'Todas las ciudades']) !!}
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" id="data_offer_at">
                            <label class="control-label"> <input type="checkbox" class="i-checks" id="offer"> Ofertó</label>
                            <div class="input-daterange input-group" id="datepicker_offer" data-column="13">
                                <input type="text" class="input-sm form-control" disabled id="offer_at_start" name="offer_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" disabled id="offer_at_end" name="offer_at_end"/>
                            </div>
                        </div>
                    </div>
                   {{--  <div class="col-md-4">
                        <div class="form-group" id="data_last_login_at">
                            <label class="control-label">Fecha de último login</label>
                            <div class="input-daterange input-group" id="datepicker">
                                <input type="text" class="input-sm form-control" id="last_login_at_start" name="last_login_at_start"/>
                                <span class="input-group-addon">a</span>
                                <input type="text" class="input-sm form-control" id="last_login_at_end" name="last_login_at_end"/>
                            </div>
                        </div>
                    </div> --}}
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
                            <th>Contactos</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.publishers.modal')
    @include('admin.publishers.modal-contact')
@endsection

@section('extra-js')
    <script src="/assets/js/plugins/switchery/switchery.min.js"></script>
    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
    
    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/publisherService.js"></script>
    <script>
        $(document).ready(function() {
            PublisherService.init('/medios/search');
        });
    </script>
    <!-- iCheck -->
    <script src="/assets/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function () {
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

            $("#form-create-contact-publisher").click(function() {
                var url = $('#publisherModal #newContact').data('url');

                var parameters = {
                    'action[id]':           $("#modal_contact_action_id").val(),
                    'action[action_at]':    $("#modal_contact_action_date").val(),
                    'comments':             $("#modal_contact_comments").val(),
                    '_token':               $("#contact_csrf_token").val()
                };

                $.post(url, parameters, function( data ) {

                    $("#publisherContactModal input").val("");
                    $("#publisherContactModal textarea").val("");

                    if(data.success) {
                        PublisherService.reload();
                        var socialContact = PublisherService.getSocialContact(data.contact);
                        $('#publisherModal #comments').prepend(socialContact);
                    }
                    else {
                        console.log('error');
                    }
                });
            });

        });


    </script>
@endsection