<div class="modal fade" id="spaceModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg list-space">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <div class="row">
                    <div class="col-xs-8">
                        <h2 class="modal-title h4" style="font-size: 17px;">
                            <span style="font-weight: 300;">Medio:</span> <a id="publisher_company" class="text-success" href="#" target="_blank"></a><br>
                            <span style="font-weight: 300;">Espacio:</span>  <span id="space_name" class="h5 text-success" style="font-size:17px;"></span><br>
                            <button id="space_selected" class="btn btn-sm">
                                
                            </button>
                        </h2>
                    </div>
                    <div class="col-xs-4">
                        <div id="prueba">
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="float: left;"> Datos - <strong>(Creado <span id="created_at"></span>)</strong></h4>
                                <div class="ibox-tools">
                                    <button class="btn btn-xs btn-warning" id="editProposalTitle">
                                        <i class="fa fa-pencil"></i>
                                    </button>  
                                </div>
                            </div>
                            <div class="panel-body" style="max-height: 493px; overflow: scroll;">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p><strong>Título</strong> <br> <span id="proposal_space_title"></span></p>
                                        <p><strong>Descripción</strong> <br> <span id="proposal_space_description"></span> </p>
                                        <hr>
                                    </div>
                                    

                                    <div class="col-xs-12" id="space-description">
                                        
                                    </div>

                                    <div class="col-xs-12" id="space-audiences">
                                        
                                    </div>
                                </div> <br>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td style="min-width: 130px;"><span class="h5 font-bold"> Categoría </span></td>
                                                    <td><span class="h5" id="category_name">  </span> </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0.2em 0;"><span class="h5 font-bold"> Sub Categoría </span></td>
                                                    <td><span class="h5" id="sub_category_name">  </span> </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0.2em 0;"><span class="h5 font-bold"> Formato </span> </td>
                                                    <td><span class="h5" id="format_name">  </span> <br></td>
                                                </tr>
                                                <tr style="padding: 0.5em; display: block;"></tr>
                                                <tr style="border-bottom: 1px solid rgba(189, 189, 189, 0.47);">
                                                    <td style="padding: 0.3em 0;"><span class="h5 font-bold"> Escenarios </span></td>
                                                    <td><span class="h5" id="impact_scene_name">  </span> </td>
                                                </tr>
                                                <tr style="border-bottom: 1px solid rgba(189, 189, 189, 0.47);">
                                                    <td style="padding: 0.3em 0;"><span class="h5 font-bold"> Ciudades </span></td>
                                                    <td><span class="h5" id="city_name">  </span> </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0.2em 0;"><span class="h5 font-bold"> Dirección </span></td>
                                                    <td><span class="h5" id="address">  </span> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-5">
                        
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="float: left;"> Precios del Espacio </h4>
                                <div class="ibox-tools">
                                    <button id="newDiscount" data-url="-" class="btn btn-sm btn-success" style="padding: 0px 5px;"><i class="fa fa-usd"></i></button>    
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <p style="margin-bottom: 0;">
                                            <span class="h5"> Precio Mínimo</span> <br>
                                            <span class="h5"> Markup</span> <br>
                                            <span class="h5"> Markup</span> <br>
                                            <span class="h5 font-bold text-success"> Precio Público</span> <br>
                                            <span class="h5"> Impactos</span> <br>
                                            <span class="h5"> Comisión</span>
                                        </p>
                                    </div>
                                    <div class="col-xs-7">
                                        <p>
                                            <span class="h5" id="minimal_price"> </span> <br>
                                            <span class="h5" id="markup"> </span> <br>
                                            <span class="h5" id="markup_price"> </span> <br>
                                            <span class="h5 font-bold text-success" id="public_price"> </span>
                                            / <span class="h5 font-bold text-success" id="period"> </span> <br>
                                            <span class="h5" id="impacts"> </span> <br>
                                            <span class="h5" id="publisher_commission_rate">  </span> % 
                                        </p>
                                    </div>
                                    <div class="col-xs-12">
                                        <hr>
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

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <a href="#" class="btn btn-warning" id="modalProposalEdit" data-toggle="tooltip"><i class="fa fa-pencil"></i> Editar</a>

                {{-- <button class="btn btn-primary actionSpaceModal" id="modalProposalSpace" data-toggle="tooltip" data-placement="left" title="Agregar a propuesta" style="margin-right: 8px;"><i class="fa fa-plus-circle"></i></button>

                <button class="btn btn-success actionSpaceModal" id="modalSuggestSpace" data-toggle="tooltip" data-placement="top" title="Recomendar espacio" style="margin-right: 8px;"><i class="fa fa-location-arrow"></i></button>

                <a href="#" class="btn btn-info" id="modalPublisher" data-toggle="tooltip" data-placement="top" title="Ver espacios del Medio" style="margin-right: 8px;"><i class="fa fa-twitch"></i></a>

                
                <a href="#" id="delete_space" data-spaceid="0" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Borrar espacio"><i class="fa fa-trash"></i></a> --}}
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