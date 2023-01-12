<div class="row text-center containerfluid plomo" style="margin: 2rem 0">
  <div class="col-md-3 text-left">
    <div style="padding-bottom:1rem; padding-top:0">
      <img src="images/Logo.png" class="img-fluid" alt="">
    </div>
    <h4 class="py-3"><strong>This is us</strong></h4>
    <p>Somos una empresa familiar dedicada al turismo, teniendo como objetivo conectarnos con el cliente, brindando experiencias unicas e inolvidables y dando servicio de calidad a precios accesibles.</p>
  </div>
  <div class="col-md-9">
    <div class=""style="padding-top:2rem; padding-bottom:0;">
      <hr class="hr2">
    </div>
    <div class="row" style="padding-top:0%; ">
      <div class="col-md-4 col-sm-12 col-xs-12">
        <h3 class="py-3"><strong>Travel News!</strong></h3>

        <div class="row align-items-center  text-left">
          <?php $i=1?>
          @foreach ($articulos_footer as $ar)

          <div class="col-md-12 col-xl-5 col-lg-5 col-sm-5" >
            <img src="{{$ar->imagen}}" alt="" width="100%">
          </div>
          <div class="col-md-12 col-xl-7 col-lg-7 col-sm-7">
            <div class="letra3"><strong>{{$ar->titulo}}</strong></div>
            <p style="font-size: 14px; line-height: 16px;">{{substr($ar->resumen,0, 40)}}...</p>
            <p style="font-size: 12px; ">{{$ar->created_at}}...</p>
          </div>

          <?php $i=$i+1?>
          @endforeach

        </div>
      </div>
            <!-- columna de correo -->
      <div class="col-md-4 col-sm-12 order-3 order-sm-2 py-3">
        <h3 style="padding-bottom:1rem"><strong>Mailing List</strong></h3>
        <p>Sign up for our mailling list to get latest updates and offers.</p>
        <div class="row py-2">
          <div class="input-group col-md-12 container py-4">
            <input type="email" placeholder="your Email" name="your Email" class="form-control">
            <i class="fas fa-check input-group-addon ico2"></i>
          </div>
          <div class=" col-md-12 container">
            <p><small>We respect your privacy</small></p>
            <div class="display-4 py-2" style="font-size:35px">
              <i class="fab fa-facebook"></i>
              <i class="fab fa-twitter-square"></i>
              <i class="fab fa-google-plus-square"></i>
              <i class="fab fa-linkedin"></i>
              <i class="fab fa-vimeo-square"></i>
              <i class="fab fa-app-store-ios"></i>
              <i class="fab fa-contao"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-12 col-xs-12 py-3">
        <h3><strong>Discover</strong></h3>
        <br>
        <div class="row text-center" style="">
          <div class="col-md-12 col-xl-6 col-lg-6 col-sm-6">
              <li>Why Host</li>
              <br>
              <li>Social Connect</li>
              <br>
              <li>Site Map</li>
          </div>
          <div class="col-md-12 col-xl-6 col-lg-6 col-sm-6 pt-2">
              <li>Blog Post</li>
              <br>
              <li>Help Topics</li>
              <br>
              <li>Polices</li>
          </div>
        </div>
        <div class="text-center" style="padding-top:70px; font-size:1.3rem">
          <i class="fas fa-phone-volume letra3"><span class="plomo">  1-251-1520-HELLO</span></i>
          <a href="#"><p class="letra3">help@travelo.com</p></a>
        </div>
      </div>
    </div>
  </div>
</div>
