<div class="modal fade suggestSpaceModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 16px 10px;">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 class="modal-title" style="font-size: 18px; font-weight: 300;">
                    <span id="suggest-space"></span> Recomendar espacio
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
                    <div class="col-md-12" style="margin-bottom: 10px;">
                        <h3 id="suggestSpacePublisher" style="font-weight: 300; text-align: center;"></h3>
                    </div>
                    <div class="col-md-12" style="margin-bottom: 20px;">
                        <h3 id="suggestSpaceName" style="font-weight: 500; text-align: center;"></h3>
                    </div>
                    <div class="col-md-12" style="margin-bottom: 50px;">
                        {!! Form::select('advertisers', $advertisers, null, ['class' => 'advertisr-chosen-select', 'multiple', 'data-placeholder' => 'Anunciantes']) !!}
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button id="form-suggest-space-close" class="btn btn-effect-ripple btn-default" data-dismiss="modal">Cerrar</button>
                <button id="form-suggest-space" class="btn btn-effect-ripple btn-primary form-edit-data">Recomendar</button>
            </div>
        </div>
    </div>
</div>