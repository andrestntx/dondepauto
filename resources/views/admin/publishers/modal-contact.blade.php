<div class="modal inmodal" id="publisherContactModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title">
                    Nuevo contacto
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-12">
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-md-3"> <h3 style="font-size: 20px; margin: 7px 0;">Contacto</h3> </div>
                            
                                <div class="col-md-3" style="margin-bottom: 10px;">
                                    {!! Form::select('type', ['call' => 'Llamada', 'chat' => 'Chat', 'email' => 'Email'], null, ['id' => 'modal_contact_type', 'class' => 'form-control']) !!}
                                </div>

                                <div class="col-md-12">
                                    {!! Form::textarea('comments', null, ['rows' => '3', 'id' => 'modal_contact_comments', 'class' => 'form-control']) !!}
                                </div> 
                            </div>
                        </div>

                        <div class="col-md-6">
                            {!! Field::select('action_id', $actionsPublisher, ['label' => 'Acción', 'id' => 'modal_contact_action_id', 'required']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('action_date', ['label' => 'Fecha', 'class' => 'datetimepicker', 'id' => 'modal_contact_action_date', 'required']) !!}
                        </div>

                        <input type="hidden" id="contact_csrf_token" name="_token" value="{{ csrf_token() }}">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="form-create-contact-publisher-close" class="btn btn-effect-ripple btn-default" data-dismiss="modal">Cerrar</button>
                <button id="form-create-contact-publisher" class="btn btn-effect-ripple btn-primary" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>