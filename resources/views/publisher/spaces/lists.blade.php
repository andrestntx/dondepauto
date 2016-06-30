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
                        <h1>Mi inventario de Medios</h1>
                    </div>
                </div>  
            </div>          
        </div>

        <div class="col-xs-12 text-center content">
            <a href="{{ route('medios.espacios.create', $publisher) }}" class="btn btn-lg btn-warning btn-effect-ripple btn-xlg">
                <i class="fa fa-plus-circle"></i> CREAR NUEVA OFERTA
            </a> 
        </div>

        <div class="col-md-12 list-spaces" id="listSpaces">
        <div class="ibox">
            <div class="ibox-content">
                 <div class="table-responsive">
                    <table id="spaces-datatable" class="table table-striped table-bordered table-hover table-condensed" cellspacing="0" width="100%">
                        <thead>
                            <tr class="info">
                                <th></th>
                                <th>Espacio</th>
                                <th>Categoría</th>
                                <th>Formato</th>
                                <th>Precio base</th>
                                <th>Calidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($publisher->spaces as $space)
                                <tr>
                                    <td></td>
                                    <td> {{ $space->name }} </td>
                                    <td> {{ $space->category_name }} / {{ $space->sub_category_name }} </td>
                                    <td> {{ $space->format_name }} </td>
                                    <td> {{ $space->minimal_price }} </td>
                                    <td> {{ $space->points }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Espacio</th>
                                <th>Categoría</th>
                                <th>Formato</th>
                                <th>Precio base</th>
                                <th>Calidad</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>    
   
@endsection

@section('extra-js')
    <script>
        
    </script>
@endsection