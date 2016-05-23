@extends('layouts.admin')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('spaces.space', $space) !!}
@endsection

@section('content')
    <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($space, $formData) !!}

                            <legend class="h4">Datos Básicos</legend>
                            <div class="col-md-12">
                                {!! Field::text('name') !!}
                            </div>
                            
                            <div class="col-md-4">
                                {!! Field::text('impact') !!}
                            </div>
                            <div class="col-md-4">
                                {!! Field::text('minimal_price') !!}
                            </div>
                            <div class="col-md-4">
                                {!! Field::select('period', $periods, ['empty' => 'seleccione un período']) !!}
                            </div>
                            <div class="col-md-12">
                                {!! Field::textarea('description') !!}
                            </div>

                            <legend class="h4" style="padding-top: 10px;">Restricciones</legend>
                            <div class="col-md-4" style="padding-left: 35px; padding-top: 10px;">
                                <div class="checkbox m-r-xs">
                                    {!! Form::checkbox('alcohol_restriction', 1, null, ['id' => 'alcohol_restriction']) !!}
                                    <label for="alcohol_restriction">
                                        Restringe Alcohol
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-left: 35px; padding-top: 10px;">
                                <div class="checkbox m-r-xs">
                                    {!! Form::checkbox('snuff_restriction', 1, null, ['id' => 'snuff_restriction']) !!}
                                    <label for="snuff_restriction">
                                        Restringe Tabaco
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4" style="padding-left: 35px; padding-top: 10px;">
                                <div class="checkbox m-r-xs">
                                    {!! Form::checkbox('policy_restriction', 1, null, ['id' => 'policy_restriction']) !!}
                                    <label for="policy_restriction">
                                        Restringe Política
                                    </label>
                                </div>
                            </div>

                            <legend class="h4" style="padding-top: 10px;">Formato</legend>
                            <div class="col-md-12">
                                {!! Field::select('format_id', $formats, ['class' => 'select2-format']) !!}
                            </div>

                            <legend class="h4" style="padding-top: 10px;">Ubicación</legend>
                            <div class="col-md-12">
                                {!! Field::text('address') !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('city_id', $cities) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Field::select('impact_scene_id', $scenes) !!}
                            </div>

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

        $(".select2-format").select2({
            placeholder: "Seleccione un formato",
            allowClear: true
        });

    </script>
@endsection