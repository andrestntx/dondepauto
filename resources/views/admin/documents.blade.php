@extends('layouts.admin')

@section('action')
    
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('documents') !!}
@endsection

@section('extra-css')
    
@endsection

@section('content')
    
    <div class="col-xs-12 col-md-6">
        <div class="ibox" id="search-space">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-xs-12">
                        <h2>Documentos DP</h2>
                        <p class="h5"><a href="/documents/publishers/rut_donde_pauto.pdf" title="RUT" target="_blank"> <i class="fa fa-file-pdf-o"></i> RUT.pdf</a></p>
                        <p class="h5"><a href="/documents/publishers/camara_comercio.pdf" title="Cámara de comercio" target="_blank"> <i class="fa fa-file-pdf-o"></i> Cámara_de_comercio.pdf</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-12 col-md-6">
        <div class="ibox" id="search-space">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::open(['route' => 'documents.post', 'files' => 'true']) !!}
                            {!! Field::file('rut', ['label' => 'RUT']) !!}
                            {!! Field::file('commerce', ['label' => 'Cámara de comercio']) !!}    
                            <button class="btn btn-success">Subir documentos</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('extra-js')
   
@endsection