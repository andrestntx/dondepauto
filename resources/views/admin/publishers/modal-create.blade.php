<div class="modal inmodal" id="publisherCreateModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title">
                    Nuevo medio
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-sm-6">
                            {!! Field::text('name', ['required', 'id' => 'modal_name']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Field::text('company', ['required', 'id' => 'modal_company']) !!}
                        </div>
                         <div class="col-sm-6">
                            {!! Field::text('cel', ['required', 'id' => 'modal_cel']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Field::email('email', ['required', 'id' => 'modal_email']) !!}
                        </div>
                        
                        <div class="col-sm-12">
                            <hr>
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-sm-3"> <h3 style="font-size: 17px; margin: 7px 0;">Contacto</h3> </div>
                            
                                <div class="col-sm-3" style="margin-bottom: 10px;">
                                    {!! Form::select('type', ['call' => 'Llamada', 'chat' => 'Chat', 'skype' => 'Skype'], null, ['id' => 'modal_contact_type', 'class' => 'form-control']) !!}
                                </div>

                                <div class="col-sm-12">
                                    {!! Form::textarea('comments', null, ['rows' => '3', 'id' => 'modal_publisher_contact_comments', 'class' => 'form-control']) !!}
                                </div> 
                            </div>
                        </div>

                        <div class="col-sm-6">
                            {!! Field::select('action_id', $actionsPublisher, ['label' => 'Acción', 'id' => 'modal_publisher_contact_action_id', 'required']) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! Field::text('action_date', ['label' => 'Fecha', 'class' => 'datetimepicker', 'id' => 'modal_publisher_contact_action_date', 'required']) !!}
                        </div>

                        <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="form-create-publisher-close" class="btn btn-effect-ripple btn-default" data-dismiss="modal">Cerrar</button>
                <button id="form-create-publisher" class="btn btn-effect-ripple btn-primary" data-url="{{ route('medios.store') }}">Crear medio</button>
            </div>
        </div>
    </div>
</div>