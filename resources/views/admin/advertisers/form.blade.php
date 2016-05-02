@extends('layouts.admin')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('advertisers.advertiser', $advertiser) !!}
@endsection

@section('content')
    <div class="col-sm-10 col-sm-offset-1 col-lg-8 col-lg-offset-2">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4>Datos del Anunciante</h4>
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