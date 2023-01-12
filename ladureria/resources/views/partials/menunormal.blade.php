@include('partials.menuresponsive')
<div class="row" id="headerimage" style="@if (isset($imagen)) background: url('/{{$imagen}}') center center no-repeat; @else  background: url(/image/headeralturaok.jpg) center center no-repeat; @endif">
    <div class="container" >
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" >
            <a href="/"><img src="{{URL::asset('/image/logo1.png')}}" class="img-responsive "></a>
        </div>

        <div class="col-lg-8 col-md-8 col-lg-offset-1 col-md-offset-1 hidden-sm hidden-xs " style="margin-top: 6%;">
            <!--<div class="text-right" style="top: 0;"><label><b class="letrasheader">EN /</b> <a href="es/" class="letrasheader letrasblancas">ES</a></label></div>-->
            <ul class="nav menusup nav-pills" style="padding-top: 10%;">
                <li role="presentation"><a href="/aboutus/#whyus" >Why us</a></li>
                <li role="presentation"><a href="/destinations/peru/1" >Destinations</a></li>
                <li role="presentation"><a href="/ourtrips" >Our trips</a>
                    <ul style="padding: 0" class="pull-left text-left">
                        <li style="border-radius: 5px; width: 150px;"><a href="/makeityourown" class="pull-left text-left letrasheader">Make it your own</a></li>
                    </ul>
                </li>
                <li role="presentation"><a href="/aboutus" >About Us</a></li>
                <li role="presentation"><a href="#!" id="scrollcontact" >Contact</a></li>
                <li role="presentation"><a href="/blog" >Blog</a></li>
            </ul>
        </div>

    </div>
</div>