<div class="modal fade" id="spaceModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg list-space">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <div class="row">
                    <div class="col-xs-8">
                        <h2 class="modal-title h4" style="font-size: 15px;">
                            <strong>Medio:</strong> <a id="publisher_company" href="#" target="_blank"></a><br>
                            <strong>Espacio:</strong>  <span id="space_name" class="h5" style="font-size:15px;"></span><br>
                            Creado el:  <span id="space_crated_at_date" class="h5" style="font-size:14px;"></span>
                        </h2>
                    </div>
                    <div class="col-xs-4 timeline" id="prueba">

                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Descripción - Activo
                                <div id="space_sw_active" style="display: inline-block;">
                                    
                                </div>
                            </div>
                            <div class="panel-body scroll_content">
                                <div class="row">
                                    <div class="col-xs-12" id="space-description">
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Imagenes
                            </div>
                            <div class="panel-body scroll_content_image">
                                <div class="row">
                                    <div class="col-xs-12 lightBoxGallery" id="space-images">
                                        
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Detalles del Espacio - <strong>(Creado <span id="created_at"></span>)</strong>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <p>
                                            <span class="h5 font-bold"> Categoría </span> <br>
                                            <span class="h5 font-bold"> Sub Categoría </span> <br>
                                            <span class="h5 font-bold"> Formato </span> <br><br>
                                            <span class="h5 font-bold"> Escenario </span> <br>
                                            <span class="h5 font-bold"> Ciudad </span> <br>
                                            <span class="h5 font-bold"> Dirección </span>
                                        </p>
                                    </div>
                                    <div class="col-xs-8">
                                        <p>
                                            <span class="h5" id="category_name">  </span> <br>
                                            <span class="h5" id="sub_category_name">  </span> <br>
                                            <span class="h5" id="format_name">  </span> <br><br>
                                            <span class="h5" id="impact_scene_name">  </span> <br>
                                            <span class="h5" id="city_name">  </span> <br>
                                            <span class="h5" id="address">  </span>
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Precios del Espacio
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <p>
                                            <span class="h5"> Precio Mínimo</span> <br>
                                            <span class="h5"> Markup</span> <br>
                                            <span class="h5"> Markup</span> <br>
                                            <span class="h5"> Precio Público</span>
                                            <span class="h5"> Impactos</span>
                                        </p>
                                    </div>
                                    <div class="col-xs-7">
                                        <p>
                                            <span class="h5" id="minimal_price"> </span> <br>
                                            <span class="h5" id="markup"> </span> <br>
                                            <span class="h5" id="markup_price"> </span> <br>
                                            <span class="h5 font-bold text-info" id="public_price"> </span>
                                            / <span class="h5" id="period"> </span> <br>
                                            <span class="h5" id="impacts"> </span> 
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Datos de contacto
                            </div>
                            <div class="panel-body">
                                <p>
                                    <span class="h5 font-bold"> <span id="publisher_name">  </span> </span> <br>
                                    <span class="h5"> <span id="publisher_company_role">  </span> </span> <br>
                                    <span class="h5" id="publisher_email"> <i class="fa fa-envelope-o"></i> <a href=""> </a></span> <br>
                                        <span class="h5">   <i class="fa fa-phone"></i> <a href="tel:" id="publisher_phone">  </a> -
                                                            <i class="fa fa-mobile"></i> <a href="tel:" id="publisher_cel">  </a>
                                        </span>
                                </p>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Acuerdo con el Medio <strong id="publisher_signed_agreement"></strong>
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
                                            <span class="h5" id="publisher_commission_rate">  </span> % <br>
                                            <span class="h5" id="publisher_signed_at">  </span> <br>
                                            <span class="h5" id="publisher_discount">  </span> % <br>
                                            <span class="h5" id="publisher_retention"> </span> %
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="modal-footer">
                
                <button class="btn btn-primary actionSpaceModal" id="modalProposalSpace" data-toggle="tooltip" data-placement="left" title="Agregar a propuesta" style="margin-right: 8px;"><i class="fa fa-plus-circle"></i></button>

                <button class="btn btn-success actionSpaceModal" id="modalSuggestSpace" data-toggle="tooltip" data-placement="top" title="Recomendar espacio" style="margin-right: 8px;"><i class="fa fa-location-arrow"></i></button>

                <a href="#" class="btn btn-info" id="modalPublisher" data-toggle="tooltip" data-placement="top" title="Ver espacios del Medio" style="margin-right: 8px;"><i class="fa fa-twitch"></i></a>

                <a href="#" class="btn btn-warning" id="modalEdit" data-toggle="tooltip"><i class="fa fa-pencil"></i></a>
                <a href="#" id="delete_space" data-spaceid="0" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Borrar espacio"><i class="fa fa-trash"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>