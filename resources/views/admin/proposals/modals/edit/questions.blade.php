<div class="modal fade" id="questionsModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 16px 10px;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" style="font-size: 20px;">
                    <span id="user_company">{{ $advertiser->company }}</span> - Ficha técnica
                    @include('admin.proposals.modals.edit.spinner')
                </h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {!! Form::open() !!}

                        <div class="col-sm-12">
                            {!! Field::select('cities[]', $cities, $proposal->quote->cities->lists('id')->all(), ['label' => 'Ciudades', 'id' => 'question_cities', 'required', 'empty' => 'Seleccione las ciudades', 'class' => 'question-chosen-select', 'multiple', 'data-placeholder' => 'Ciudades']) !!}
                        </div>
                        
                        @foreach($proposal->quote->questions as $question)
                            <div class="col-sm-12">
                                {!! Field::textarea('questions[' . $question->id. ']', $question->pivot->answer, ['label' => $question->text, 'rows' => 2, 'data-question-id' => $question->id]) !!}
                            </div>
                        @endforeach

                    {!! Form::close() !!}
                </div>
            </div>

            <div class="modal-footer">
                <button id="form-questions-close" class="btn btn-effect-ripple btn-default" data-dismiss="modal">Cerrar</button>
                <button id="form-questions" class="btn btn-effect-ripple btn-primary form-edit-data btn-edit">Guardar</button>
            </div>
        </div>
    </div>
</div>