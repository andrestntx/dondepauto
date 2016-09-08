<div class="modal fade" id="userModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg list-advertiser">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <div class="row">
                    <div class="col-xs-8">
                        <h2 class="modal-title h4" style="font-size: 15px;">
                            <strong>Anunciante:</strong> <span id="company_name"></span>
                        </h2>
                    </div>
                    <div class="col-xs-3 timeline" id="prueba">

                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 style="float: left;">Datos de contacto</h5>
                                    <div class="ibox-tools">
                                        <button class="btn btn-xs btn-warning" id="edit-data-contact">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </div>
                                </div>
                            <div class="panel-body">
                                <p>
                                    <span class="h5"> <span id="name">  </span> </span> <br>
                                    <span class="h5"> 
                                        <i class="fa fa-user"></i> 
                                        <span id="company_role"></span> 
                                        -
                                        <i class="fa fa-building-o"></i> 
                                        <span id="company_area"></span> 
                                    </span> <br>
                                    <span class="h5" id="email"> <i class="fa fa-envelope-o"></i> <a href=""> o </a></span> <br>
                                    <span class="h5">   <i class="fa fa-phone"></i> <a href="tel:567878" id="phone">  </a> -
                                        <i class="fa fa-mobile"></i> <a href="tel:+3142308171" id="cel">  </a> <br>
                                    </span>
                                    <span class="h5"> Fuente: <span id="source">  </span>  </span> 
                                    
                                </p>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 style="float: left; width: 80%;">Detalle del anunciante - <strong>(Registrado <span id="created_at"></span>)</strong></h5>
                                <div class="ibox-tools">
                                    <button class="btn btn-xs btn-warning" id="edit-data-detail">
                                        <i class="fa fa-pencil"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <p>
                                            <span class="h5"> Actividad</span> <br>
                                            <span class="h5"> Ciudad </span> <br>
                                            <span class="h5"> Dirección </span> <br> <br>
                                            <span class="h5"> NIT </span> <br>
                                            <span class="h5"> Área </span> <br>
                                        </p>
                                    </div>
                                    <div class="col-xs-8">
                                        <p>
                                            <span class="h5" id="economic_activity"> </span> <br>
                                            <span class="h5" id="city">  </span> <br>
                                            <span class="h5" id="address"> </span> <br> <br>
                                            <span class="h5" id="company_nit">  </span> <br>
                                            <span class="h5" id="company_area">  </span> <br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="float: left;">Contactos</h4>
                                <div class="ibox-tools">
                                    <button id="newContact" data-url="-" class="btn btn-sm btn-success" style="padding: 0px 5px;"><i class="fa fa-plus"></i></button>    
                                </div>
                            </div>
                            <div class="panel-body" id="comments" style="padding: 10px 10px 0 10px; height: 100px; overflow: auto;">
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Intereses y Leads <strong>(<span id="count_intentions">0</span>)</strong> <span id="lead_dates"></span>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-7">
                                        <p class="h5" style="margin: 0 0 6px;"> Intereses</p> <br>
                                        <p class="h5" style="margin: 0 0 6px;"> <strong>Leads (<span id="count_leads">0</span>)</strong></p>
                                        <p class="h5" style="margin: 0 0 6px;"> - Pendientes por contactar</p>
                                        <p class="h5" style="margin: 0 0 6px;"> - En gestión</p>
                                        <p class="h5" style="margin: 0 0 6px;"> - Ventas cerradas </p>
                                        <p class="h5" style="margin: 0 0 6px;"> - Descartadas </p>
                                    </div>
                                    <div class="col-xs-5">
                                        <p>
                                            <span class="badge badge-default" id="interest"> 0</span> <br><br><br>

                                            <span class="badge badge-warning" id="by_contact"> 0</span> <br> 
                                            <span class="badge badge-info" id="management"> 0 </span> <br>
                                            <span class="badge badge-primary" id="sold"> 0 </span> <br>
                                            <span class="badge badge-danger" id="discarded"> 0 </span>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="#" class="btn btn-info" id="link-proposals"> 
                    <i class="fa fa-newspaper-o"></i> 
                    Propuestas <span id="count-proposals">(0)</span>
                </a>
                <a href="#" id="modalEdit" class="btn btn-warning" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                <a href="#" id="delete_advertiser" data-url="0" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Borrar anunciante"><i class="fa fa-trash"></i></a>
            </div>
        </div>
    </div>
</div>