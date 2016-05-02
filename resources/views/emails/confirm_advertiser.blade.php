@extends('emails.confirm_registration')

@section('title')
    <span style='color:#00AEEF;'> {{ $user->first_name }} </span>, te invitamos a convertirte en usuario de nuestra plataforma
@endsection

@section('text1')
    Queremos que hagas parte de nuestra extensa red de anunciantes y medios publicitarios
@endsection

@section('text2')
    DóndePauto es el primer mercado electrónico en Colombia de medios publicitarios en revistas, prensa, radio, tv,
    publicidad interior y exterior, y contenidos online. Registrándote podrás acceder a nuestro catálogo de espacios de pauta
    y obtener beneficios que harán de DóndePauto tu alternativa ideal para la compra de espacios publicitarios.
    Haz <a href="http://www.dondepauto.co/aceptar-invitacion-registro/{{ $code }}">click aquí</a> para continuar.
@endsection