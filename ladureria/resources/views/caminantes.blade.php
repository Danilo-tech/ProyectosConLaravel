@extends("layouts/master")
@section('pageTitle', 'Caminantes')
@section('cuerpo')
    <div class="parallax-container section" data-parallax-img="/images/bg-01-1920x718.jpg">
        <div class="parallax-content section-34 section-md-66 text-lg-left context-dark bg-overlay-info">
            <div class="container section-34 section-md-66 text-lg-left">
                <div class="d-none d-md-block d-lg-inline-block">
                    <h1 class="font-weight-bold"><span class="big">Caminantes</span></h1></div>
                <div class="pull-lg-right offset-md-top-10 offset-lg-top-41">
                    <ul class="p list-inline list-inline-dashed">
                        <li class="list-inline-item text-safety-orange"><a href="/">Inicio</a></li>
                        <li class="list-inline-item text-safety-orange"><a href="/la-guarderia">La guardería</a></li>
                        <li class="list-inline-item">Caminantes</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <section class="section novi-background section-lg-bottom-0 section-66">
        <div class="container">
            <div class="row justify-content-sm-center align-items-lg-center">
                <div class="col-sm-10 col-lg-6 text-lg-left">
                    <h1 class="font-weight-bold text-primary">Diversidad de herramientas para <br>estimularlos</h1>
                    <div class="offset-top-30 offset-lg-top-50">
                        <p>La riqueza, variedad, y frecuencia adecuada de estímulos ayudan a lograr un desarrollo armónico en cada peque. Contamos con ambientes diseñados para acompañar la exploración de quienes recién empiezan a caminar y ofrecemos materiales adecuados y seguros para permitirles indagar el mundo con libertad.</p>
                    </div>
                    <div class="offset-top-20 offset-lg-top-30"><a class="btn btn-safety-orange" href="/contacto">Contáctanos</a></div>
                </div>
                <div class="col-sm-10 col-lg-6"><img class="img-fluid d-none d-lg-inline-block offset-top-10" src="/images/ttl_4666-2588x2336.jpg" width="573" height="517" alt=""></div>
            </div>
        </div>
    </section>
    <div class="parallax-container section" data-parallax-img="/images/bg-02-1920x748.jpg">
        <div class="parallax-content section-66 context-dark">
            <div class="container">
                <h1 class="font-weight-bold">¿Preguntas?</h1>
                <div class="row justify-content-sm-center offset-top-20">
                    <div class="col-sm-10 col-sm-8">
                        <div>
                            <p>Si desea hablar sobre un determinado plan o programa, con gusto responderemos todas sus preguntas.</p>
                        </div>
                        <div class="offset-top-30"><a class="btn btn-icon btn-icon-left btn-default" href="/contacto"><span class="novi-icon icon mdi-email-outline mdi"></span><span>Escriba su mensaje</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop