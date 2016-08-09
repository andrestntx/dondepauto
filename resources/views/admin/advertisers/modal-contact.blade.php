<div class="modal inmodal" id="advertiserContactModal" tabindex="-1" role="dialog"  aria-hidden="true">
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
                        <div class="col-md-6">
                            {!! Field::select('action_id', $actions, ['label' => 'Acción', 'id' => 'modal_contact_action_id']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('action_date', ['label' => 'Fecha', 'class' => 'datepicker', 'id' => 'modal_contact_action_date']) !!}
                        </div>
                        <div class="col-md-12">
                            {!! Field::textarea('comments', ['rows' => '3', 'id' => 'modal_contact_comments']) !!}
                        </div>
                        <input type="hidden" id="contact_csrf_token" name="_token" value="{{ csrf_token() }}">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="form-create-contact-advertiser-close" class="btn btn-effect-ripple btn-default" data-dismiss="modal">Cerrar</button>
                <button id="form-create-contact-advertiser" class="btn btn-effect-ripple btn-primary" data-dismiss="modal">Guardar contacto</button>
            </div>
        </div>
    </div>
</div>