@extends('layouts.admin')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('directors.director', $user) !!}
@endsection

@section('content')
    <div class="col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-9 col-lg-offset-1">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h4>Datos del Director</h4>
            </div>
            <div class="ibox-content">
                {!! Form::model($user, $formData) !!}
                    {!! Field::text('first_name') !!}
                    {!! Field::text('last_name') !!}
                    {!! Field::text('email') !!}
                    {!! Field::password('password') !!}
                    {!! Field::password('password_confirmation') !!}
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-effect-ripple btn-primary">Guardar Director</button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection