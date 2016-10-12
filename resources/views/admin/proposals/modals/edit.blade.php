<div class="modal fade" id="editProposalModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="modal-title h4" style="font-size: 15px;">
                            <strong>Propuesta</strong>
                            <div style="display: inline-block; vertical-align: middle;">
                                <div class="sk-spinner sk-spinner-circle" id="sk-spinner-modal" style="display: none;">
                                    <div class="sk-circle1 sk-circle"></div>
                                    <div class="sk-circle2 sk-circle"></div>
                                    <div class="sk-circle3 sk-circle"></div>
                                    <div class="sk-circle4 sk-circle"></div>
                                    <div class="sk-circle5 sk-circle"></div>
                                    <div class="sk-circle6 sk-circle"></div>
                                    <div class="sk-circle7 sk-circle"></div>
                                    <div class="sk-circle8 sk-circle"></div>
                                    <div class="sk-circle9 sk-circle"></div>
                                    <div class="sk-circle10 sk-circle"></div>
                                    <div class="sk-circle11 sk-circle"></div>
                                    <div class="sk-circle12 sk-circle"></div>
                                </div>  
                            </div>
                        </h2>
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 form_proposal_edit">
                        {!! Form::open() !!}
                            <div class="row">
                                <div class="col-sm-12">
                                    {!! Field::text('title', 0, ['label' => 'Título', 'required']) !!}    
                                </div>  
                                <div class="col-sm-12">
                                    {!! Field::text('description', ['label' => 'Descripción', 'required']) !!}  
                                </div>  
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success form-button-data" id="formProposalModal" title="Guardar" data-url="/"> Guardar</button>
            </div>
        </div>
    </div>
</div>
