<div class="modal inmodal" id="advertiserCreateModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title">
                    Nuevo anunciante
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            {!! Field::text('first_name', ['required', 'id' => 'modal_first_name']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('last_name', ['required', 'id' => 'modal_last_name']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('company', ['required', 'id' => 'modal_company']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::email('email', ['required', 'id' => 'modal_email']) !!}
                        </div>
                        <div class="col-md-12">
                            <legend class="h4">Próxima acción</legend>
                        </div>
                        <div class="col-md-6">
                            {!! Field::select('action_id', $actions, ['label' => 'Acción', 'id' => 'modal_action_id']) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Field::text('action_date', ['label' => 'Fecha', 'class' => 'datepicker', 'id' => 'modal_action_date']) !!}
                        </div>
                        <div class="col-md-12">
                            {!! Field::textarea('comments', ['rows' => '3', 'id' => 'modal_comments']) !!}
                        </div>
                        <input type="hidden" id="csrf_token" name="_token" value="{{ csrf_token() }}">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="form-create-advertiser-close" class="btn btn-effect-ripple btn-default" data-dismiss="modal">Cerrar</button>
                <button id="form-create-advertiser" class="btn btn-effect-ripple btn-primary" data-dismiss="modal" data-url="{{ route('anunciantes.store') }}">Crear anunciante</button>
            </div>
        </div>
    </div>
</div>