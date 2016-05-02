<div class="modal fade" id="advertiserModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg list-advertiser">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <div class="row">
                    <div class="col-xs-2">
                        <h2 class="modal-title h4" style="font-size: 15px;">
                            Anunciante <br><span id="company_name"></span>
                        </h2>
                    </div>
                    <div class="col-xs-9 timeline" id="prueba">

                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Datos de contacto
                            </div>
                            <div class="panel-body">
                                <p>
                                    <span class="h5"> <span id="name"> Andres Pinzon </span> </span> <br>
                                    <span class="h5" id="email"> <i class="fa fa-envelope-o"></i> <a href="mailto:andres@dondepauto.co"> andres@dondepauto.co </a></span> <br>
                                        <span class="h5">   <i class="fa fa-phone"></i> <a href="tel:567878" id="phone"> 567878 </a> -
                                                            <i class="fa fa-mobile"></i> <a href="tel:+3142308171" id="cel"> 3142308171 </a>
                                        </span>
                                </p>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Detalle del anunciante
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <p>
                                            <span class="h5"> Actividad</span> <br>
                                            <span class="h5"> Ciudad </span> <br>
                                            <span class="h5"> Dirección </span> <br>
                                            <span class="h5"> NIT </span> <br>
                                            <span class="h5"> Cargo </span> <br>
                                            <span class="h5"> Área </span> <br>
                                        </p>
                                    </div>
                                    <div class="col-xs-8">
                                        <p>
                                            <span class="h5" id="economic_activity"> </span> <br>
                                            <span class="h5" id="city">  </span> <br>
                                            <span class="h5" id="address"> </span> <br>
                                            <span class="h5" id="company_nit">  </span> <br>
                                            <span class="h5" id="company_role">  </span> <br>
                                            <span class="h5" id="company_area">  </span> <br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Intenciones de compra
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <p style="margin-top: 4px;">
                                            <span class="h5"> Pendientes por contactar</span> <br>
                                            <span class="h5"> Ventas cerradas </span> <br>
                                            <span class="h5"> Descartadas </span> <br>
                                        </p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p>
                                            <span class="badge badge-warning" id="by_contact"> 12</span> <br>
                                            <span class="badge badge-primary" id="sold"> 5 </span> <br>
                                            <span class="badge badge-danger" id="discarded"> 6 </span>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Campañas
                            </div>
                            <div class="panel-body">
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Actividad del Usuario
                            </div>
                            <div class="panel-body">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="#" id="modalEdit" class="btn btn-warning" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                <a href="#" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Desactivar anunciante"><i class="fa fa-trash"></i></a>
            </div>
        </div>
    </div>
</div>