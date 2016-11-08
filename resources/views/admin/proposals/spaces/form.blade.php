@extends('layouts.publisher')

@section('breadcrumbs')
    {!!  Breadcrumbs::render('publishers.publisher', $publisher) !!}
@endsection

@section('extra-css')
    <!-- Sweet Alert -->
    <link href="/assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    @include('publisher.spaces.form.css')
@endsection

@section('content')
    <div class="se-pre-con"></div>
    <div id="serverImages" data-images="{{ $space->images_list }}"></div>
    
    <div class="col-md-8 col-md-offset-2 text-center" id="space" data-space-id="{{ $space->id }}">
        <h2 id="title-page">
            Editar oferta de {{ $publisher->company }}
        </h2>
        <h3 class="text-success" id="proposal" data-proposal-id="{{ $proposal->id }}">
            {{ $proposal->title }}
        </h3>
        @include('publisher.spaces.modal')
    </div>

    @include('publisher.spaces.form.content')
@endsection

@section('extra-js')    
    <!-- Sweet alert -->
    <script src="/assets/js/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="/assets/js/services/proposal/quoteService.js"></script>
    @include('publisher.spaces.form.js')

@endsection