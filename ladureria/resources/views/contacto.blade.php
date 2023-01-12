@extends("layouts/master")
@section('pageTitle', 'Contacto')
@section('cuerpo')
    <div class="parallax-container section" data-parallax-img="/images/bg-01-1920x718.jpg">
        <div class="parallax-content section-34 section-md-66 text-lg-left context-dark bg-overlay-info">
            <div class="container">
                <div class="d-none d-md-block d-lg-inline-block">
                    <h1 class="font-weight-bold"><span class="big">Contáctanos</span></h1></div>
                <div class="pull-lg-right offset-md-top-10 offset-lg-top-41">
                    <ul class="p list-inline list-inline-dashed">
                        <li class="list-inline-item text-safety-orange"><a href="/">Inicio</a></li>
                        <li class="list-inline-item">Contacto</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="section novi-background section-98 section-lg-110 text-xl-left">
        <div class="container">
            <div class="row justify-content-sm-center justify-content-sm-center">
                <div class="col-xl-4">
                    <h1 class="text-uppercase font-weight-bold text-primary">Dónde encontrarnos</h1><address class="contact-info offset-top-50"><p class="h6 text-uppercase font-weight-bold text-safety-orange font-default offset-top-20">Dirección</p><p>Av. Collasuyo 3283, a una cuadra del real plaza, Cucso</p><dl><dt>Teléfono</dt><dd><a href="tel:#">: +51&nbsp;934596098</a></dd></dl><dl><dt>Correo electrónico:&nbsp;</dt><dd><a href="mailto:#">laluderia@andinoschool.edu.pe </a></dd></dl></address><address class="contact-info offset-top-50"><p class="h6 text-uppercase font-weight-bold text-safety-orange font-default">Horarios de atención</p><dl class="offset-top-20"><dt class="font-weight-bold">Lunes a Viernes:</dt><dd>&nbsp;7 am – 8 pm</dd></dl><dl><dt class="font-weight-bold">Sábado:</dt><dd>8 pm – 8 pm</dd></dl><dl><dt class="font-weight-bold">Domingos:</dt><dd>10 am – 6 pm</dd></dl></address></div>
                <div class="col-md-8 offset-top-66 offset-xl-top-0">
                    <h1 class="text-uppercase font-weight-bold text-primary">Ponte en contacto</h1>
                    <form action="/send-mail" method="post">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label form-label-outside rd-input-label" for="contact-us-name">Nombre:</label>
                                    <input class="form-control" id="contact-us-name" type="text" name="name" data-constraints="@Required" required>
                                </div>
                            </div>
                            <div class="col-xl-6 offset-top-20 offset-xl-top-0">
                                <div class="form-group">
                                    <label class="form-label form-label-outside rd-input-label" for="contact-us-email">Correo electrónico:</label>
                                    <input class="form-control" id="contact-us-email" type="email" name="email" data-constraints="@Required @Email" required>
                                </div>
                            </div>
                            <div class="col-xl-12 offset-top-20">
                                <div class="form-group">
                                    <label class="form-label form-label-outside rd-input-label" for="contact-us-message">Mensaje:</label>
                                    <textarea class="form-control" id="contact-us-message" name="message" data-constraints="@Required" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="group-sm text-center text-xl-left offset-top-30">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-primary" type="submit">Enviar</button>
                            <button class="btn btn-default" type="reset">Borrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <div class="parallax-container section" data-parallax-img="/images/bg-02-1920x748.jpg">
        <div class="parallax-content section-66 context-dark">
            <div class="container">
                <h1 class="font-weight-bold">Ven a verlo</h1>
                <div class="row justify-content-sm-center offset-top-20">
                    <div class="col-sm-10 col-sm-8">
                        <div>
                            <p>¿Quieres venir a echar un vistazo? Coordina una visita aquí:</p>
                        </div>
                        <div class="offset-top-30"><a class="btn btn-icon btn-icon-left btn-default" href="#" data-waypoint-to="#form-child-care"><span class="novi-icon icon mdi-email-outline mdi"></span>Envianos tu&nbsp;mensaje</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="google-map-container section" data-center="Av. Collasuyo 3283, Cusco, Perú" data-zoom="16" data-key="AIzaSyAf4uGYCbYijIO-gqxbbvos0wdm102dbjQ" data-icon="images/66-512-288x361.png" data-icon-active="images/66-512-276x353.png" data-styles="[{&quot;featureType&quot;:&quot;landscape&quot;,&quot;stylers&quot;:[{&quot;hue&quot;:&quot;#FFBB00&quot;},{&quot;saturation&quot;:43.400000000000006},{&quot;lightness&quot;:37.599999999999994},{&quot;gamma&quot;:1}]},{&quot;featureType&quot;:&quot;road.highway&quot;,&quot;stylers&quot;:[{&quot;hue&quot;:&quot;#FFC200&quot;},{&quot;saturation&quot;:-61.8},{&quot;lightness&quot;:45.599999999999994},{&quot;gamma&quot;:1}]},{&quot;featureType&quot;:&quot;road.arterial&quot;,&quot;stylers&quot;:[{&quot;hue&quot;:&quot;#FF0300&quot;},{&quot;saturation&quot;:-100},{&quot;lightness&quot;:51.19999999999999},{&quot;gamma&quot;:1}]},{&quot;featureType&quot;:&quot;road.local&quot;,&quot;stylers&quot;:[{&quot;hue&quot;:&quot;#FF0300&quot;},{&quot;saturation&quot;:-100},{&quot;lightness&quot;:52},{&quot;gamma&quot;:1}]},{&quot;featureType&quot;:&quot;water&quot;,&quot;stylers&quot;:[{&quot;hue&quot;:&quot;#0078FF&quot;},{&quot;saturation&quot;:-13.200000000000003},{&quot;lightness&quot;:2.4000000000000057},{&quot;gamma&quot;:1}]},{&quot;featureType&quot;:&quot;poi&quot;,&quot;stylers&quot;:[{&quot;hue&quot;:&quot;#00FF6A&quot;},{&quot;saturation&quot;:-1.0989010989011234},{&quot;lightness&quot;:11.200000000000017},{&quot;gamma&quot;:1}]}]">
        <div class="google-map"></div>
        <ul class="google-map-markers">
            <li data-location="https://goo.gl/maps/zVhNuWBNQn7er5KW9"></li>
        </ul>
    </section>
@stop