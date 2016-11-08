@extends('layouts.admin-simple')

@section('container')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-8 col-sm-8 col-xs-6">
            @yield('breadcrumbs', Breadcrumbs::render('home'))
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-6">
            <div class="title-action" style="padding: 0;">
                @yield('action')
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row">
            @yield('content')
        </div>
    </div>
@endsection