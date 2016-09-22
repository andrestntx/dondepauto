<div class="modal fade questionsModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 16px 10px;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" style="font-size: 20px;">
                    <span id="user_company"></span> - Solicitud de cotización
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
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        {!! Field::select('type', ['call' => 'Llamada', 'chat' => 'Chat', 'email' => 'Email', 'meet' => 'Reunión'], ['id' => 'question_contact_type', 'label' => 'Contacto']) !!}
                    </div>
                    <div class="col-sm-6">
                        {!! Field::text('action_date', ['label' => 'Fecha', 'class' => 'datetimepicker', 'id' => 'question_action_date', 'required']) !!}
                    </div>
                    <div class="col-sm-12">
                        {!! Field::text('title', ['label' => 'Titulo', 'required']) !!}
                    </div>
                    <div class="col-sm-12">
                        {!! Field::select('cities', $cities, ['label' => 'Ciudades', 'id' => 'question_cities', 'required', 'empty' => 'Seleccione las ciudades', 'class' => 'question-chosen-select', 'multiple', 'data-placeholder' => 'Ciudades']) !!}
                    </div>
                    <div class="col-sm-12">
                        {!! Field::select('audiences', $audiences, ['label' => 'Audiencias', 'id' => 'question_audiences', 'required', 'empty' => 'Seleccione las audiencias', 'class' => 'question-chosen-select', 'multiple', 'data-placeholder' => 'Audiencias']) !!}
                    </div>

                    
                    @foreach($questions as $question)
                        <div class="col-sm-12">
                            {!! Field::textarea('questions[' . $question->id. ']', ['label' => $question->text, 'rows' => 2, 'data-question-id' => $question->id]) !!}
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="modal-footer">
                <button id="form-questions-close" class="btn btn-effect-ripple btn-default" data-dismiss="modal">Cerrar</button>
                <button id="form-questions" class="btn btn-effect-ripple btn-primary form-edit-data">Guardar</button>
            </div>
        </div>
    </div>
</div>