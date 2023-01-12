<div class="modal-dialog modal-dialog-centered modal-lg m-0 p-0" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h2 class="modal-title font-weight-bold" id="exampleModalCenterTitle">{{$servicio->nombre}}</h2>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="fas fa-times"></i></span>
      </button>
    </div>
    <div class="modal-body m-lg-4 m-2">     
      <div class="row">       
        <div class="col-6">
         {!! Html::image($servicio->imagen, $servicio->nombre,['class'=>'img-fluid']) !!}
        </div>
        <div class="col-6 text-left">
         <h4 class="mb-md-3 m-0 font-weight-normal"><u>{{$servicio->subtitulo}}</u></h4>
          <p class="text-justify">{!!$servicio->descripcion!!}</p>
        </div>
      </div>
    </div>
    </div>
</div>