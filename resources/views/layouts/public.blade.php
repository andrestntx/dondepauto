<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DodePauto.CO</title>
        <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        @yield('extra-css')
    </head>
    <body>
        @yield('content')
        
        <!-- Mainly scripts -->
        <script src="/assets/js/jquery-2.1.1.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        @yield('extra-js')

        <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
        
    </body>
</html>
