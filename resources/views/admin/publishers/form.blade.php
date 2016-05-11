@extends('layouts.admin')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')
    <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4>Datos del Medio</h4>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($publisher, $formData) !!}
                            @include('admin.users.default-inputs')

                            @if($publisher->exists)
                                @include('admin.users.password-inputs')
                                @include('admin.users.personal-inputs')
                                @include('admin.users.company-inputs')

                                <legend class="h4" style="padding-top: 10px;">Acuerdo</legend>
                                <div class="col-md-6" style="padding-left: 35px; padding-top: 10px;">
                                    <div class="checkbox m-r-xs">
                                        {!! Form::checkbox('signed_agreement', 1, null, ['id' => 'signed_agreement']) !!}
                                        <label for="signed_agreement">
                                            Acuerdo firmado
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {!! Field::text('signed_at', ['class' => 'datepicker']) !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Field::text('commission_rate') !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Field::text('retention') !!}
                                </div>
                                <div class="col-md-6">
                                    {!! Field::text('discount') !!}
                                </div>

                                @include('admin.users.comments')

                            @endif

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-effect-ripple btn-primary">Guardar cambios</button>
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
    <script>
        $('.datepicker').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });
    </script>
@endsection