@extends('layouts.admin')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')
    <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4>Registro complementario</h4>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::model($publisher, $formData) !!}
                            {!! Field::text('phone') !!}
                            {!! Field::text('cel') !!}
                            {!! Field::text('company_nit') !!}
                            {!! Field::text('company_role') !!}
                            {!! Field::select('city_id', $cities, ['empty' => 'Seleccione la ciudad']) !!}
                            {!! Field::text('address') !!}
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
            autoclose: true,
            format: 'yyyy-mm-dd',
        });
    </script>
@endsection