<div class="modal fade" id="modalDownloads" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="max-width: 500px; margin: auto;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h2 class="modal-title h4" style="font-size: 10px;">
                    <strong>.</strong>
                </h2>
            </div>

            <div class="modal-body" >
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h2 style="color:#45BC53; margin-top: 0; font-weight: 400; margin-bottom: 1em; font-size: 2em;">Descarga de cotización</h2>
                    </div>
                    @foreach($proposal->downloads->sortByDesc('created_at') as $pdf)
                        <div class="col-sm-offset-1 col-sm-10 download-file" style="font-size: 1.2em; padding-bottom: 1em; border-bottom: 2px #c5c5c5 solid; margin-bottom: 1em;">
                            <a href="{{ $pdf->url }}" title="" target="_blank" style="font-weight: 500; font-size: 1.2em; color:gray;">
                                <i class="fa fa-file-pdf-o fa-2x" style="margin-right: 10px; font-size: 1.5em;"></i>
                                {{ $pdf->created_at->format('d-M-y h:i a') }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
