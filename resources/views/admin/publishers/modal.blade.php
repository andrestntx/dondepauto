<div class="modal fade" id="userModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg list-publisher">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <div class="row">
                    <div class="col-xs-7">
                        <h2 class="modal-title h4" style="font-size: 15px;">
                            <strong>Medio:</strong> <span id="company_name"></span> <span id="publisher_logo"></span>
                        </h2>
                        {!! Form::select('tag_id', $tags, null, ['placeholder' => 'Sin marca', 'class' => 'select-tags']) !!}
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
                                    <span class="h5" id="email"> <i class="fa fa-envelope-o"></i> <a href=""> </a></span> <br>
                                        <span class="h5">   <i class="fa fa-phone"></i> <a href="tel:" id="phone">  </a> -
                                                            <i class="fa fa-mobile"></i> <a href="tel:+" id="cel">  </a> 
                                        </span> <br>
                                    <span class="h5"> Fuente: <span id="source">  </span>  </span> <br>
                                    <span class="h5"> Comentarios: <span id="text-comments" style="font-weight: 400;"> </span>  </span> 
                                </p>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div style="display: inline-block; width: 46%;">
                                    Acuerdo <strong id="publisher_signed_agreement"></strong>
                                    <div id="publisher_sw_agreement" style="display: inline-block;">
                                        
                                    </div>
                                </div>
                                <div class="ibox-tools" style="display: inline-block; width: 50%;">
                                    <button class="btn btn-xs btn-warning" id="edit-data-agreement" target="_blank">
                                        <i class="fa fa-pencil"></i>
                                    </button>
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
                                    <div class="col-xs-12" style="margin-top: 10px;">
                                        <a href="/" class="h5" style="color: #5555e8;" target="_blank" id="link-documents">Documentos <strong id="publisher_documents"></strong></a> 
                                        <div id="publisher_sw_documents" style="display: inline-block;"></div>  
                                        <ul id="file-documents" class="list-unstyled file-list" style="margin-top: 10px;">
                                        
                                        </ul> 
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 style="float: left; width: 80%;">Detalle del medio - <strong>(Registrado <span id="created_at"></span>)</strong></h5>
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
                                            <span class="h5"> Dirección </span> <br>

                                            <span class="h5"> NIT </span> <br>
                                            <span class="h5"> Razón social </span> <br> <br>
                                            
                                            <span class="h5"> <strong>Repre. Legal</strong> </span> <br>
                                            <span class="h5"> Nombre </span> <br>
                                            <span class="h5"> Email </span> <br>
                                            <span class="h5"> Documento </span> <br>
                                            <span class="h5"> Teléfono </span> <br>
                                        </p>
                                    </div>
                                    <div class="col-xs-8">
                                        <p>
                                            <span class="h5" id="economic_activity"> </span> <br>
                                            <span class="h5" id="city">  </span> <br>
                                            <span class="h5" id="address"> </span> <br>

                                            <span class="h5" id="company_nit">  </span> <br>
                                            <span class="h5" id="company_legal">  </span> <br><br><br>

                                            <span class="h5" id="repre_name">  </span> <br>
                                            <span class="h5" id="repre_email">  </span> <br>
                                            <span class="h5" id="repre_doc">  </span> <br>
                                            <span class="h5" id="repre_phone">  </span> <br>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="#" class="btn btn-info" id="link-spaces" target="_blank"> 
                    <i class="fa fa-newspaper-o"></i> 
                    Espacios Publicitarios <span id="count-spaces">(0)</span>
                </a>  
                <a href="#" class="btn btn-success" target="_blank" id="modalShow" data-toggle="tooltip"><i class="fa fa-user"></i></a>
                <a href="#" class="btn btn-warning" target="_blank" id="modalEdit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                <a href="#" id="delete_publisher" data-url="0" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Borrar Medio"><i class="fa fa-trash"></i></a>
            </div>
        </div>
    </div>
</div>
