@extends('layouts.admin')

@section('extra-css')
    <link href="/assets/css/prueba.css" rel="stylesheet">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body ">
                    <div class="row timeline">
                      <div class="col-sm-8 col-sm-offset-2 linea"></div>
                      <div class="col-sm-2 col-sm-offset-1 text-center">
                        <button class="btn btn-primary btn-circle btn-lg steps-img" type="button"><i class="fa fa-child"></i></button>
                        <p class="steps-name">
                          Registro inicial
                        </p>
                      </div>

                      <div class="col-sm-2 text-center">
                        <button class="btn btn-primary btn-circle btn-lg steps-img" type="button"><i class="fa fa-envelope"></i></button>
                        <p class="steps-name">
                          Validación de email
                        </p>
                      </div>

                      <div class="col-sm-2 text-center">
                        <button class="btn btn-danger btn-circle btn-lg steps-img" type="button"><i class="fa fa-edit"></i></button>
                        <p class="steps-name">
                          Complementario
                        </p>
                      </div>

                      <div class="col-sm-2 text-center">
                        <button class="btn btn-danger btn-circle btn-lg steps-img" type="button"><i class="fa fa-file-text-o"></i></button>
                        <p class="steps-name">
                          Firmó acuerdo
                        </p>
                      </div>

                      <div class="col-sm-2 text-center">
                        <button class="btn btn-danger btn-circle btn-lg steps-img" type="button"><i class="fa fa-tags"></i></button>
                        <p class="steps-name">
                          Ofertó
                        </p>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
