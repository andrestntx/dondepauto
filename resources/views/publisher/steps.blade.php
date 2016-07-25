<div class="figures">
    <figure class="col-sm-4">
        @if($publisher->complete_data)
            <img src="/assets/icons/aggrement/icono1gris.png">
            <p><i class="fa fa-check"></i> Completaste tus datos</p>
        @else
            <img src="/assets/icons/aggrement/icono1azul.png">
            <p><i class="fa fa-check"></i> Completa tus datos</p>
        @endif
    </figure>
    <figure class="col-sm-4">
        @if($publisher->count_spaces > 0)
            <img src="/assets/icons/aggrement/icono2gris.png">
            <p><i class="fa fa-check"></i> Publicaste tus ofertas</p>
        @else
            <a href="{{ route('medios.espacios.first-create', $publisher) }}">  <img src="/assets/icons/aggrement/icono2azul.png"> </a>
            <p><a style="color: gray;" href="{{ route('medios.espacios.first-create', $publisher) }}"><i class="fa fa-exclamation-triangle" style="color: #80DAF2;"></i> <strong>Publica tus ofertas</strong></p></a>
        @endif
    </figure>
    <figure class="col-sm-4">
        @if($publisher->has_signed_agreement)
            <img src="/assets/icons/aggrement/icono3gris.png">
            <p><i class="fa fa-check"></i> Formalizaste el acuerdo de servicios y tus ofertas están activas</p>
        @elseif($publisher->in_verification)
            <img src="/assets/icons/aggrement/icono3gris.png">
            <p><i class="fa fa-check"></i> <strong style="color: #4ead1f;">Documentos en verificación</strong></p>
        @else
            <a href="{{ route('medios.agreement.complete', $publisher) }}"> <img src="/assets/icons/aggrement/icono3azul.png"> </a>
            <p><a style="color: gray;" href="{{ route('medios.agreement.complete', $publisher) }}"><i class="fa fa-exclamation-triangle" style="color: #80DAF2;"></i> <strong>Valida tu Medio Publicitario</strong></p></a>
        @endif
        
    </figure>
</div>