<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>DodePauto.CO | Admin</title>

        <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="/assets/css/animate.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">
        <link href="/assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

        <!-- Toastr style -->
        <link href="/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">

        <!-- DataPicker -->
        <link href="/assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
        <link href="/assets/css/plugins/iCheck/custom.css" rel="stylesheet">

        <!-- Select Chosen -->
        <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
        <link href="/assets/css/plugins/select2/select2.min.css" rel="stylesheet">

        <link href="/assets/css/plugins/switchery/switchery.min.css" rel="stylesheet">

        <link href="/assets/css/publisher.css" rel="stylesheet">

        <link href="/assets/css/progress.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="/assets/css/plugins/tags_input/jquery.tagsinput.css" />

        <!-- Toastr style -->
        <link href="/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">

        @yield('extra-css-layout')
        @yield('extra-css')

        <script>
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');

            fbq('init', '1576862415938596');
            fbq('track', "PageView");
        </script>

        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=1576862415938596&ev=PageView&noscript=1"
        /></noscript>


    </head>
    <body class="mini-navbar pace-done" id="publisher_company" data-company="{{ $publisher->company }}">
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element"> <span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{ $publisher->name }}</strong>
                                     </span> <span class="text-muted text-xs block">{{ $publisher->company }} </span> </a>
                            </div>
                            <div class="logo-element">
                                DP+
                            </div>
                        </li>
                        @if(auth()->user()->isPublisher())
                            @include('layouts.publisher-menu')
                        @else
                            {!! Menu::make('menu.sidebar', 'nav metismenu')
                                ->setParams([
                                    'user_id' => auth()->user()->id,
                                    'user_platform_id' => auth()->user()->user_platform_id
                                ])->render()
                            !!}
                        @endif
                    </ul>

                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                            <img src="/assets/img/logoDPHeader.png" style="height: 35px; margin-left: 10px; margin-top: 10px;" alt="Logo DondePauto">
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <span class="m-r-sm text-muted welcome-message">
                                    <a href="{{ route('home') }}" title="Menú Principal"> {{ ucfirst($publisher->company) }} </a>
                                </span>
                                <span class="m-r-sm text-muted welcome-message">
                                    <a href="{{ route('medios.espacios.index', $publisher) }}" title="Mi Inventario">Mi Inventario</a>
                                </span>
                            </li>
                            {{-- <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                                </a>
                                <ul class="dropdown-menu dropdown-messages">
                                    <li>
                                        <div class="dropdown-messages-box">
                                            <a href="profile.html" class="pull-left">
                                                <img alt="image" class="img-circle" src="/assets/img/a7.jpg">
                                            </a>
                                            <div>
                                                <small class="pull-right">46h ago</small>
                                                <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                                <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="dropdown-messages-box">
                                            <a href="profile.html" class="pull-left">
                                                <img alt="image" class="img-circle" src="/assets/img/a4.jpg">
                                            </a>
                                            <div>
                                                <small class="pull-right text-navy">5h ago</small>
                                                <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                                <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="dropdown-messages-box">
                                            <a href="profile.html" class="pull-left">
                                                <img alt="image" class="img-circle" src="/assets/img/profile.jpg">
                                            </a>
                                            <div>
                                                <small class="pull-right">23h ago</small>
                                                <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                                <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="text-center link-block">
                                            <a href="mailbox.html">
                                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                                </a>
                                <ul class="dropdown-menu dropdown-alerts">
                                    <li>
                                        <a href="mailbox.html">
                                            <div>
                                                <i class="fa fa-envelope fa-fw"></i> You have 16 messages
                                                <span class="pull-right text-muted small">4 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="profile.html">
                                            <div>
                                                <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                                <span class="pull-right text-muted small">12 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="grid_options.html">
                                            <div>
                                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                                <span class="pull-right text-muted small">4 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="text-center link-block">
                                            <a href="notifications.html">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li> --}}

                            <li>
                                <a href="/logout">
                                    <i class="fa fa-sign-out"></i> Cerrar sesión
                                </a>
                            </li>
                        </ul>

                    </nav>
                </div>

                <div class="publisher-content wrapper wrapper-content animated fadeIn">

                    <div class="row">
                        @yield('content')
                    </div>

                </div>

                <div class="footer">
                    <div class="pull-right">
                        Tu información está segura con nosotros. <a href="http://www.dondepauto.co/politica-de-privacidad/" target="_blank">Política de Privacidad</a>
                    </div>
                    <div>
                        <img src="http://www.dondepauto.co/images/logoDondePauto_Azul_Gris.png" style="width: 100px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="p3chat-launcher" data-tid="210277375" style="position:fixed;bottom:0px;left:0px;float:left;z-index:999999;">
          <img src="//p3chat.com/widget/tid/210277375/img/inline/" alt=""/>
        </div>

        <!-- Mainly scripts -->
        <script src="/assets/js/jquery-2.1.1.js"></script>
        <script src="/assets/js/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Flot -->
        <script src="/assets/js/plugins/flot/jquery.flot.js"></script>
        <script src="/assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
        <script src="/assets/js/plugins/flot/jquery.flot.spline.js"></script>
        <script src="/assets/js/plugins/flot/jquery.flot.resize.js"></script>
        <script src="/assets/js/plugins/flot/jquery.flot.pie.js"></script>
        <script src="/assets/js/plugins/flot/jquery.flot.symbol.js"></script>
        <script src="/assets/js/plugins/flot/jquery.flot.time.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="/assets/js/inspinia.js"></script>
        <script src="/assets/js/plugins/pace/pace.min.js"></script>

        <!-- Sparkline -->
        <script src="/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

        <script src="/assets/js/plugins/confirm/jquery.confirm.min.js"></script>

        <!-- Toastr script -->
        <script src="/assets/js/plugins/toastr/toastr.min.js"></script>

        <!-- Data picker -->
        <script src="/assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

        <!-- Chosen -->
        <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>

        <!-- Select2 -->
        <script src="/assets/js/plugins/select2/select2.full.min.js"></script>

        <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Validation -->
        <script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>

        <!-- Switchery -->
        <script src="/assets/js/plugins/switchery/switchery.min.js"></script>

        <script src="/assets/js/plugins/tags_input/jquery.tagsinput.js"></script>

        <!-- Steps -->
        <script src="/assets/js/plugins/staps/jquery.steps.min.js"></script>

        <!-- Bootbox -->
        <script src="/assets/js/plugins/bootbox/bootbox.min.js"></script>

        <!-- DROPZONE -->
        <script src="/assets/js/plugins/dropzone/dropzone.js"></script>

        <!-- CIRCLE PROGRESS -->
        <script src="/assets/js/jquery-asPieProgress.min.js"></script>

        <script src="/assets/js/plugins/number/jquery.number.min.js"></script>

        <script src="http://malsup.github.com/jquery.form.js"></script>

        <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>

        <!-- Toastr script -->
        <script src="/assets/js/plugins/toastr/toastr.min.js"></script>

        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "progressBar": true,
                "preventDuplicates": false,
                "positionClass": "toast-top-full-width",
                "onclick": null,
                "showDuration": "400000",
                "hideDuration": "10000",
                "timeOut": "20000",
                "extendedTimeOut": "10000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        </script>

        <script>
            $(".chosen-select").chosen({disable_search_threshold: 10});

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        </script>

        @yield('extra-js-layout')
        @yield('extra-js')

        <script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
        <script type="text/javascript">twttr.conversion.trackPid('nutxt', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
        <noscript>
            <img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=nutxt&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
            <img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=nutxt&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
        </noscript>

        <script>
          var p3chat = p3chat || [];
          p3chat.push(['_setAccount', '094551266']);
          p3chat.push(['_trackPage']);
          (function (d, t, id) {
            if (d.getElementById(id)) return;
            var e = d.createElement(t),
                s = d.getElementsByTagName(t)[0];
            e.src = "//p3chat.com/dist/p3.js"; e.id = id;
            s.parentNode.insertBefore(e, s);
          }(document, 'script', 'p3chat-snippet'));
        </script>

    </body>
</html>

{!! Alert::render('themes/alert-toastr') !!}
