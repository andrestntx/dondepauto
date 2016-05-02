<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>DondePauto - Admin | Login</title>

        <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="/assets/css/animate.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">

    </head>

    <body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <img src="/assets/img/logoDPHeader.png" class="img-responsive m-b-lg" alt="Logo DondePauto">
            <p class="m-b">Por favor, ingrese su correo electronico y su contraseña para iniciar sesión</p>
            {!! Form::open(['url' => 'login', 'method' => 'POST', 'class' => 'm-t']) !!}
                {!! Field::email('email', ['ph' => 'Correo electrónico', 'tpl' => 'themes.bootstrap.fields.horizontal']) !!}
                {!! Field::password('password', ['ph' => 'Contraseña', 'tpl' => 'themes.bootstrap.fields.horizontal']) !!}
                <button type="submit" class="btn btn-primary block full-width m-b">Iniciar Sesión</button>
                <a href="#"><small>¿Olvidó su contraseña?</small></a>
            {!! Form::close() !!}
            <p class="m-t"> <small>Sistema de administración - DondePauto &copy; 2016</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>

    </body>

</html>
