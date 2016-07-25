@extends('layouts.publisher')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="/assets/css/publisher/dashboard.css" />
@endsection

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('content')
    <div class="dashboard">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 text-center">
                        <h1>{{ $publisher->company }}</h1>
                    </div>
                </div>  
            </div>          
        </div>

        <div class="col-xs-12 text-center sub-title sub-title-lg">
            <h2>Activa y valida tu medio publicitario</h2>
        </div>

        <div class="col-xs-8 col-xs-offset-2 agreement-info" id="icons">
            @include('publisher.steps')
        </div>

    </div>    
   
@endsection

@section('extra-js')
    <script>
        
    </script>
@endsection