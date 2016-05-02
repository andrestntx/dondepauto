@extends('layouts.admin')

@section('breadcrumbs')
    {!! Breadcrumbs::render('advisers.adviser', $user) !!}
@endsection

@section('extra-css')
    <link href="/assets/css/prueba.css" rel="stylesheet">
@endsection

@section('content')
    <div class="col-sm-4 col-md-3" id="urlSearch" data-url="@yield('urlSearch','/asesores/' . $user->id .'/anunciantes/search')">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="row m-b-lg">
                    <div class="col-lg-12 text-center" id="adviserId" data-ids="{{ $user->id }}">
                        <h2>{{ $user->first_name }}</h2>

                        <div class="m-b-sm">
                            <img alt="image" class="img-circle" src="/assets/img/a2.jpg"
                                 style="width: 62px">
                        </div>
                        <div class="m-b-sm">
                            <p><strong>ASESOR</strong></p>
                            <p>{{ $user->name }}</p>
                            <p>{{ $user->email }}</p>
                            <p>{{ $user->tel }}</p>
                        </div>
                        <div class="col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 m-b-sm">
                            <a href="{{ route('asesores.edit', $user) }}" class="btn btn-info btn-block">
                                <i class="fa fa-pencil"></i> Editar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8 col-md-9">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Anunciantes asignados <strong id="count-advertisers">({{ $advertisers->count() }})</strong></h2>
                        <p>
                            Todos los anunciantes que han sido asignados a {{ $user->first_name }}
                        </p>
                    </div>
                    <div class="col-sm-6">
                        <div class="pull-right">
                            <a href="#link" class="btn btn-primary" id="link">Asingar</a>
                            <a href="#unlink" class="btn btn-warning" disabled id="unlink">Desvincular</a>
                        </div>
                    </div>

                    <div class="clients-list col-xs-12">
                        <div class="full-height-scroll">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover advertisers-datatable" id="unlink-advertisers">
                                    <thead>
                                        <tr class="info">
                                            <th><i class="fa fa-building-o"></i> Empresa</th>
                                            <th>Nombre</th>
                                            <th><i class="fa fa-envelope"></i> Email</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th><i class="fa fa-building-o"></i> Empresa</th>
                                            <th>Nombre</th>
                                            <th><i class="fa fa-envelope"></i> Email</th>
                                            <th>Estado</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal inmodal fade" id="advertisersModal" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                                    <h4 class="modal-title">Asignar anunciantes</h4>
                                    <p class="font-bold">Seleccione los anunciantes que asigará al asesor <strong> {{ $user->name }} </strong> </p>
                                </div>
                                <div class="modal-body">
                                    <table id="link-advertisers" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr class="info">
                                                <th>Empresa</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Empresa</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Estado</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="modal-confirm" disabled>Asignar</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    
    <script src="/assets/js/services/userService.js"></script>
    <script src="/assets/js/services/adviserService.js"></script>
    <script>
        $(document).ready(function() {
            AdviserService.init();
        });

    </script>
@endsection