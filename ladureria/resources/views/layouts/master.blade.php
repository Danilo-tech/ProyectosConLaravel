<!DOCTYPE html>
<html class="wow-animation" lang="en">

<head>
    <title>@yield('pageTitle')</title>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1,maximum-scale=1,user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="keywords" content="intense web design multipurpose template">
    <meta name="date" content="Dec 26">
    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=PT+Sans:400,700%7CAmatic+SC:400,700">
    <link media="all" type="text/css" rel="stylesheet" href="{!! asset('/css/style.css') !!}">
    <link media="all" type="text/css" rel="stylesheet" href="{!! asset('/css/novi.css') !!}">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>

<body>
<style>
    .ie-panel {
        display: none;
        background: #212121;
        padding: 10px 0;
        box-shadow: 3px 3px 5px 0 rgba(0, 0, 0, .3);
        clear: both;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    html.ie-10 .ie-panel,
    html.lt-ie-10 .ie-panel {
        display: block;
    }
</style>
<div class="ie-panel">
    <a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="/images/ie8-panel/warning_bar_0000_us.jpg" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a>
</div>
<div class="page text-center">
    <header class="section page-head">
        <div class="rd-navbar-wrap">
            <nav class="rd-navbar rd-navbar-top-panel novi-background rd-navbar-light" data-lg-stick-up-offset="79px" data-md-device-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-static" data-lg-auto-height="true" data-md-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-stick-up="true">
                <div class="rd-navbar-inner">
                    <div class="rd-navbar-top-panel">
                        <div class="container">
                            <div class="left-side"><address class="contact-info text-left"><span class="p"><span class="novi-icon icon mdi mdi-phone-forward text-primary text-middle"></span></span><a class="text-middle" href="tel:#">555&nbsp;-555rriente&nbsp; <br></a><span class="p"><span class="novi-icon icon mdi mdi-map-marker-circle text-primary text-middle"></span></span><a class="text-middle" href="/contacto"> Av. Qollasuyo 0000, frente a la placita&nbsp;Qosqo</a></address></div>
                            <div class="right-side offset-top-4 offset-xl-top-0 text-center">
                                <div class="contact-info text-left d-inline-block"><span class="p"><span class="novi-icon icon mdi mdi-clock-end text-primary text-middle"></span><span class="text-middle"><span data-novi-id="2">Sab–Dom: </span>10:00am–7:00pm<span data-novi-id="1"> Lun</span>: 7:00am–9:00am <span data-novi-id="0">Mar</span>:&nbsp;A toda hora</span>
                                        </span>
                                </div>
                                <ul class="list-inline list-inline-xs d-inline-block inset-xl-left-80 text-middle">
                                    <li class="list-inline-item"><a href="#"><span class="novi-icon icon fa-bitcoin"></span></a></li> <br>

                                    <li class="list-inline-item"><a href="#"><span class="novi-icon icon fa-instagram"></span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container section-relative d-flex justify-content-between">
                        <div class="rd-navbar-panel">
                            <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar, .rd-navbar-nav-wrap"><span></span></button>
                            <button class="rd-navbar-top-panel-toggle" data-rd-navbar-toggle=".rd-navbar, .rd-navbar-top-panel"><span></span></button>
                            <div class="rd-navbar-brand">
                                <a class="d-none d-xl-block" href="/"><img id="imglogo" width="220" height="90" src="/images/Grão-Café-Luderia-em-João-Pessoa-Fachada-Logo.jpg" alt=""></a>
                                <a class="d-inline-block d-xl-none" href="/"><img width="215" height="33" src="images/Grão-Café-Luderia-em-João-Pessoa-Fachada-Logo.jpg" alt=""></a>
                            </div>
                        </div>
                        <div class="rd-navbar-menu-wrap">
                            <div class="rd-navbar-nav-wrap">
                                <div class="rd-navbar-mobile-scroll">
                                    <div class="rd-navbar-mobile-brand">
                                        <a class="d-inline-block" href="/"><img width="135" height="55" src="images/logovff-luderia-16.png" alt=""></a>
                                    </div>
                                    <div class="form-search-wrap">
                                        <form class="form-search rd-search" action="search-results.html" method="GET">
                                            <div class="form-group">
                                                <label class="form-label form-search-label form-label-sm" for="rd-navbar-form-search-widget">Search</label>
                                                <input class="form-search-input input-sm form-control form-control-gray-lightest input-sm" id="rd-navbar-form-search-widget" type="text" name="s" autocomplete="off">
                                            </div>
                                            <button class="form-search-submit" type="submit"><span class="mdi mdi-magnify"></span></button>
                                        </form>
                                    </div>







                                    <ul class="rd-navbar-nav">
                                        <li @if($menu==1) class="active" @endif ><a href="/"><span>Start</span></a></li>
                                        <li @if($menu==2) class="active" @endif ><a href="/sobre"><span>About Us</span></a></li>
                                        <li @if($menu==3) class="active" @endif ><a href="/la-guarderia"><span>La Guardería</span></a></li>
                                        <li @if($menu==4) class="active" @endif ><a href="/faq"><span>¿Questions?</span></a></li>
                                        <li @if($menu==5) class="active" @endif ><a href="/contacto"><span>Contact</span></a></li>
                                    </ul>
                                </div>
                            </div>
                            {{--<div class="rd-navbar-search"><a class="rd-navbar-search-toggle mdi" data-rd-navbar-toggle=".rd-navbar-inner,.rd-navbar-search" href="#"><span></span></a>--}}
                                {{--<form class="rd-navbar-search-form search-form-icon-right rd-search" action="search-results.html" method="GET">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label class="form-label" for="rd-navbar-search-form-input">Type and hit enter...</label>--}}
                                        {{--<input class="rd-navbar-search-form-input form-control form-control-gray-lightest" id="rd-navbar-search-form-input" type="text" name="s" autocomplete="off">--}}
                                    {{--</div>--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
<!-- content -->
@yield("cuerpo")
<!-- end content -->
    <footer class="section novi-background section-relative section-top-66 section-bottom-34 page-footer">
        <div class="container">
            <div class="row justify-content-center grid-group-md text-lg-left">
                <div class="col-lg-3">
                    <div class="footer-brand">
                        <a href="/"><img width="230" height="100" src="images/logovff-luderia-2.png" alt=""></a>
                    </div>
                    <ul class="list-inline list-inline-xxs d-inline-block offset-top-34 post-meta text-dark list-inline-primary">
                        <li class="list-inline-item"><a href="#"><span class="novi-icon icon icon-xxs fa-facebook"></span></a></li>
                        <li class="list-inline-item"><a href="#"><span class="novi-icon icon icon-xxs fa-instagram"></span></a></li>
                    </ul>
                </div>
                <div class="col-lg-5">
                    <h6 class="text-uppercase text-spacing-60 font-default">Nuestro&nbsp;Boletín</h6>
                    <p>Mantente al tanto de nuestras noticias, novedades y promociones. Inserta tu correo para suscribirte a nuestro boletín. </p>
                    <div class="offset-top-30">
                        <form class="rd-mailform" data-form-output="form-subscribe-footer" data-form-type="subscribe" method="post" action="bat/rd-mailform.php">
                            <div class="form-group">
                                <div class="input-group input-group-sm"><span class="input-group-prepend"><span class="input-group-text input-group-icon"><span class="mdi mdi-email"></span></span>
                                        </span>
                                    <input class="form-control" placeholder="Entra tu correo electrónico" type="email" name="email" data-constraints="@Required @Email"><span class="input-group-append"></span>
                                    <button class="btn btn-sm btn-primary" type="submit">Subscribete</button>
                                </div>
                            </div>
                            <div class="form-output" id="form-subscribe-footer"></div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3 offset-xxl-1">
                    <ul class="list list-unstyled address contact-info text-left">
                        <li>
                            <div class="unit unit-spacing-xxs flex-row">
                                <div class="unit-left"><span class="novi-icon icon icon-xxs mdi mdi-phone text-primary text-middle"></span></div>
                                <div class="unit-body"><a class="text-middle" href="tel:#">+51&nbsp;934596098</a></div>
                            </div>
                        </li>
                        <li>
                            <div class="unit unit-spacing-xxs flex-row">
                                <div class="unit-left"><span class="novi-icon icon icon-xxs mdi mdi-map-marker-radius text-primary text-middle"></span></div>
                                <div class="unit-body"><a class="text-middle" href="/contacto">Av. Collasuyo 3258, a una cuadra del Real Plaza, Cucso</a></div>
                            </div>
                        </li>
                        <li>
                            <div class="unit unit-spacing-xxs flex-row">
                                <div class="unit-left"><span class="novi-icon icon icon-xxs mdi mdi-clock text-primary text-middle"></span></div>
                                <div class="unit-body"><span class="text-middle"><span data-novi-id="4">Lun–vie</span><span data-novi-id="5">:</span>&nbsp;07:00am–8:00pm
                                        <br><span data-novi-id="6">Sab: </span>
                                        <br><span data-novi-id="7">Dom:</span> 10:00am–6:00pm</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container offset-top-50">
            <p class="small text-darker">La Ludería ©
                <span id="copyright-year">2019</span>.
                {{--<span data-novi-id="3">--}}
                    {{--<a href="#"></a>Política de privacidad.--}}
                {{--</span>--}}
                Desarrollado por
                <span data-novi-id="8">
                    PuntoPro
                </span>
            </p>
        </div>
    </footer>
</div>
<div class="snackbars" id="form-output-global"></div>
<script src="{!! asset('js/core.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('js/script.js') !!}" type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

            @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
<script>

    $(document).on("scroll", function(){
        //sacamos el desplazamiento actual de la página
        var desplazamientoActual = $(document).scrollTop();

        if(desplazamientoActual > 90){
            $("#imglogo").css({'height':'65px','width':'165px','padding-top':'8px'});

        }

        if(desplazamientoActual < 90){
            $("#imglogo").css({'height':'90px','width':'220px','padding-top':'0px'});
        }
    });


</script>

</body>
</html>