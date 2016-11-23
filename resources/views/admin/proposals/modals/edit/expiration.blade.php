<div class="modal fade" id="modalEditExpirationDays" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h2 class="modal-title h4">
                    <strong>Editar Propuesta</strong>
                    @include('admin.proposals.modals.edit.spinner')
                </h2>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 edit-form">
                        {!! Form::open() !!}
                            <div class="row">
						        <div class="col-xs-12">
						            {!! Field::number('expiration_days', $proposal->expiration_days, ['label' => 'Días de caducidad', 'required']) !!}    
						        </div>
						    </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success btn-edit"> Guardar</button>
            </div>
        </div>
    </div>
</div>
