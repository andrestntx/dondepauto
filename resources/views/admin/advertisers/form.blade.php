@extends('layouts.admin')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('advertisers.advertiser', $advertiser) !!}
@endsection

@section('extra-css')
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
@endsection


@section('content')
    <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Datos del Anunciante</h5>
                <div class="ibox-tools">
                    <button id="changeUser" data-url="{{ route('anunciantes.change', $advertiser) }}" class="btn btn-sm btn-warning" title="Convertir en MEDIO PUBLICITARIO"><i class="fa fa-user"></i> Convertir en MEDIO PUBLICITARIO</button>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($advertiser, $formData) !!}

                            @include('admin.users.default-inputs')
                            <div class="col-md-12">
                                {!! Field::select('user_id', $advisers, ['label' => 'Asesor']) !!}
                            </div>
                            @if($advertiser->exists)
                                @include('admin.users.password-inputs')
                                @include('admin.users.personal-inputs')
                                @include('admin.users.company-inputs')
                            @endif

                            <div class="col-md-12">
                                {!! Field::select('economic_activity_id', $activities) !!}
                            </div>

                            @include('admin.users.comments')

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-effect-ripple btn-primary">Guardar Cambios</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#changeUser").click(function(){
                var url = $(this).data('url');

                swal({
                    title: '¿Estás seguro?',
                    text: 'El usuario ahora será medio publicitario',
                    type: "warning",
                    confirmButtonText: "Confirmar",
                    confirmButtonColor: "#FFAC1A",
                    cancelButtonText: "Cancelar",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    html: true
                },
                function() {
                    window.location.href = url;
                });
            });
        });
    </script>
@endsection