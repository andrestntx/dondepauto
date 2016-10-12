<div class="modal fade" id="modalQuestions" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg list-space">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <div class="row">
                    <div class="col-xs-8">
                        <h2 class="modal-title h4" style="font-size: 15px;">
                            <strong>Ficha técinica: </strong> {{ $proposal->title }}
                        </h2>
                    </div>
                    <div class="col-xs-4 timeline" id="prueba">

                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Preguntas
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12" id="space-description">
                                        @foreach($proposal->quote->questions as $question)
                                            <h3 style="font-weight: 500">{{ $question->text }}</h3>
                                            <h4 style="font-weight: 300">{{ $question->pivot->answer }}</h4>
                                        @endforeach
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