@extends('layouts.admin')

@section('action')
    <a href="{{ route('asesores.create') }}" class="btn btn-primary"><i class="fa fa-plus"> </i> Crear Asesor</a>
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('advisers') !!}
@endsection

@section('content')
    @foreach($advisers as $adviser)
        <div class="col-sm-6">
            <div class="contact-box">
                <a href="{{ route('asesores.show', $adviser) }}">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/assets/img/a2.jpg">
                            <div class="m-t-xs font-bold">Asesor</div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong>{{ $adviser->name }}</strong></h3>
                        <address>
                            <strong>DondePauto.Co</strong><br>
                            {{ $adviser->email }}
                        </address>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </div>
        </div>
    @endforeach
@endsection