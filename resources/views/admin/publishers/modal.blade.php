<div class="modal fade" id="publisherModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg list-publisher">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <div class="row">
                    <div class="col-xs-7">
                        <h2 class="modal-title h4" style="font-size: 15px;">
                            <strong>Medio:</strong> <span id="company_name"></span>
                        </h2>
                    </div>
                    <div class="col-xs-4 timeline" id="prueba">

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
                                    <span class="h5"> <span id="name">  </span> </span> <br>
                                    <span class="h5" id="email"> <i class="fa fa-envelope-o"></i> <a href=""> </a></span> <br>
                                        <span class="h5">   <i class="fa fa-phone"></i> <a href="tel:" id="phone">  </a> -
                                                            <i class="fa fa-mobile"></i> <a href="tel:+" id="cel">  </a>
                                        </span>
                                </p>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Acuerdo <strong id="publisher_signed_agreement"></strong>
                                <div id="publisher_sw_agreement" style="display: inline-block;">
                                    
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-8">
                                        <p>
                                            <span class="h5"> Porcentaje de comisión </span> <br>
                                            <span class="h5"> Fecha firma de acuerdo </span> <br>
                                            <span class="h5"> Descuento pronto pago </span> <br>
                                            <span class="h5"> Retención en la fuente</span>
                                        </p>
                                    </div>
                                    <div class="col-xs-4">
                                        <p>
                                            <span class="h5" id="commission_rate">  </span> % <br>
                                            <span class="h5" id="signed_at">  </span> <br>
                                            <span class="h5" id="discount">  </span> % <br>
                                            <span class="h5" id="retention"> </span> %
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4>Documentos <strong id="publisher_documents"></strong></h4>   
                                        <ul id="file-documents" class="list-unstyled file-list">
                                        
                                        </ul> 
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Detalle del medio - <strong>(Registrado <span id="created_at"></span>)</strong>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <p>
                                            <span class="h5"> Actividad</span> <br>
                                            <span class="h5"> Ciudad </span> <br>
                                            <span class="h5"> Dirección </span> <br><br>
                                            <span class="h5"> NIT </span> <br>
                                            <span class="h5"> Cargo </span> <br>
                                            <span class="h5"> Área </span> <br>
                                        </p>
                                    </div>
                                    <div class="col-xs-8">
                                        <p>
                                            <span class="h5" id="economic_activity"> </span> <br>
                                            <span class="h5" id="city">  </span> <br>
                                            <span class="h5" id="address"> </span> <br> <br>
                                            <span class="h5" id="company_nit">  </span> <br>
                                            <span class="h5" id="company_role">  </span> <br>
                                            <span class="h5" id="company_area"> </span> <br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Comentarios
                            </div>
                            <div class="panel-body" id="comments">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" id="link-documents" disabled data-toggle="tooltip" data-placement="top" title="Habilitar cambios de documentos" style="margin-right: 10px;"> 
                    <i class="fa fa-file-pdf-o"></i> 
                </button>
                <a href="#" class="btn btn-info" id="link-spaces" target="_blank"> 
                    <i class="fa fa-newspaper-o"></i> 
                    Espacios Publicitarios <span id="count-spaces">(0)</span>
                </a>  
                <a href="#" class="btn btn-warning" target="_blank" id="modalEdit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                <a href="#" class="btn btn-danger" id="" data-toggle="tooltip" data-placement="top" title="Desactivar anunciante"><i class="fa fa-trash"></i></a>
            </div>
        </div>
    </div>
</div>
