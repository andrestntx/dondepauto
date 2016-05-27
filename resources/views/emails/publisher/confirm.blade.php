@extends('emails.confirm_registration')

@section('title')
    <span style='color:#00AEEF;'> {{ $user->first_name }} </span>, te invitamos a convertirte en usuario de nuestra plataforma
@endsection

@section('text1')
    Queremos que hagas parte de nuestra extensa red de anunciantes y medios publicitarios
@endsection

@section('text2')
    DóndePauto es el primer mercado electrónico en Colombia de medios publicitarios en revistas, prensa, radio, tv,
    publicidad interior y exterior, y contenidos online. Registrándote podrás hacer parte del más amplio portafolio de
    espacios publicitarios del país, extendiendo tu alcance comercial y ganando exposición en nuestro marketplace online
    ante una creciente audiencia de clientes potenciales.
    Haz <a href="{{ url('/medios/confirmar/' . $code) }}">click aquí</a> para continuar
@endsection

@section('action')
    {{ url('/medios/confirmar/' . $code) }}
@endsection