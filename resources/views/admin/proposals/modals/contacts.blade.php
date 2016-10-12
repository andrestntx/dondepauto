<div class="modal fade" id="modalContacts" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg list-space">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <div class="row">
                    <div class="col-xs-8">
                        <h2 class="modal-title h4" style="font-size: 15px;">
                            <strong>Contactos: </strong> {{ $advertiser->name }}
                        </h2>
                    </div>
                    <div class="col-xs-4 timeline" id="prueba">

                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="float: left;">Contactos</h4>
                                <div class="ibox-tools">
                                    <button id="newContact" data-url="-" class="btn btn-sm btn-success" style="padding: 0px 5px;"><i class="fa fa-plus"></i></button>    
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12" id="proposal-contacts">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Seguimiento
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::select('state', ['1' => 'Aprobado', '2' => 'Descartado'], null, ['class' => 'form-control']) !!}
                                        <span class="h5"> 
                                            <span style="font-weight: 200;">Barreras y miedos:</span> 
                                        </span> <br>
                                        <span class="h5"> 
                                            <span style="font-weight: 200;">Detonantes de compra:</span> 
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
            
                
            </div>
        </div>
    </div>
</div>