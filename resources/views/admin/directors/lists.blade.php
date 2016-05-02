@extends('layouts.admin')

@section('action')
    <a href="{{ route('directores.create') }}" class="btn btn-primary"><i class="fa fa-plus"> </i> Crear Director</a>
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('directors') !!}
@endsection

@section('content')
    @foreach($directors as $director)
        <div class="col-sm-6">
            <div class="contact-box">
                <a href="{{ route('directores.show', $director) }}">
                    <div class="col-sm-3">
                        <div class="text-center">
                            <img alt="image" class="img-circle m-t-xs img-responsive" src="/assets/img/a2.jpg">
                            <div class="m-t-xs font-bold">Director</div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong>{{ $director->name }}</strong></h3>
                        <address>
                            <strong>DondePauto.Co</strong><br>
                            {{ $director->email }}
                        </address>
                    </div>
                    <div class="clearfix"></div>
                </a>
            </div>
        </div>
    @endforeach
@endsection