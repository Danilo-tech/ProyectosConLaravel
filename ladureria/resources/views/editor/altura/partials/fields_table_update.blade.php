@if (count($laterales)>0) <div class="col-md-8" style="border-right: solid 1px #CCCCCC;"> @endif
{!!Form::hidden('modelo',$modelo, ['class'=>'form-control'])!!}

<?php $i=1; $imagenes=""; ?>
@foreach ($fields as $field)
    @if ($field->mostrar!="imagen")
    <div class="form-group">
        @if ($field->mostrar=="relacion" and isset($padre))
        @else
            {!!Form::label($field->field ,$field->etiqueta, ['class'=>'control-label'])!!}
        @endif
        <div class="input-group">
            @if (in_array("required", $field->validacion))<span class="input-group-addon"><abbr title="Este campo es obligatorio"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></abbr></span>@endif
            @if ($field->traducir)<span class="input-group-addon"><abbr title="Este campo será traducido"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span></abbr></span>@endif
            <div>
                @if ($field->mostrar=="varchar")
                {!!Form::text($field->field, null, ['class'=>'form-control'])!!}
                @elseif ($field->mostrar=="textarea")
                    @if (in_array("ckeditor", $field->validacion))
                        {!!Form::textarea($field->field, null, ['class'=>'form-control  ckeditor' ])!!}
                    @else
                        {!!Form::textarea($field->field, null, ['class'=>'form-control' ])!!}
                    @endif
                @elseif ($field->mostrar=="select")
                    @if ($field->field=="producto_o_servicio")
                        {!!Form::select($field->field, array(1=>"Producto",0=>'Servicio'), null, ['class'=>'form-control'])!!}
                    @elseif (($field->field=="credito_o_ahorro"))
                        {!!Form::select($field->field, array(1=>"Credito",0=>'Ahorro'), null, ['class'=>'form-control'])!!}
                    @else
                        {!!Form::select($field->field, array(1=>"SI",0=>'NO'), null, ['class'=>'form-control'])!!}
                    @endif
                @elseif ($field->mostrar=="relacion")
                    @if (isset($padre))
                        {!!Form::hidden($field->field, $padre, ['class'=>'form-control'])!!}
                    @else
                        {!!Form::select($field->field, $field->lista, null, ['class'=>'form-control'])!!}
                    @endif
                @elseif ($field->mostrar=="updown")
                    {!!Form::text($field->field, null, ['class'=>'form-control updown'])!!}
                @endif
            </div>
        </div>
    </div>
    @else
        <div class="well">
            <?php $ref=$field->field;?>
            @if ($model_data->$ref!='')
                {!! Html::image($model_data->$ref,"",['class'=>'img-responsive']) !!}
            @endif
            <div class="form-group">
                {!!Form::label($field->field ,$field->etiqueta.' '.$field->validacion[0].' ( max '.$field->validacion[1].' )', ['class'=>'control-label'])!!}
                <div class="input-group">
                    <input name="{{$field->field}}" id="imagen{{$i}}" type="file" class="file-loading">
                    <?php $i=$i+1; $imagenes=$imagenes.$field->field.'|'; ?>
                </div>
            </div>
        </div>
    @endif
@endforeach
<input type="hidden" name="imagenes" value="{{$imagenes}}">

    <div id="myModal" class="modal fade" tabindex="1" data-width="60%" style="display: none;"></div>

    <div id="imagemodal" class="modal fade" tabindex="1" data-width="600px" style="display: none;">
        <div class="modal-content">
            <div class="modal-body">
                <img src="" class="imagepreview" style="width: 100%;" >
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
            </div>
        </div>
    </div>

    <div id="myModalConfirm" class="modal fade" tabindex="1" data-width="30%" style="display: none;">
        <div class="modal-header" style="background-color: #337ab7;">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" style="color: white;">¿Es necesario actualizar las Traducciones?</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info" role="alert" style="font-size: 12px;">
                        <p>Usted ha realizado cambios en campos que requieren ser traducidos.</p>
                        <p><b>¿Estos cambios requieren que las traducciones tambien sean actualizadas?</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default no">No</button>
            <button type="button" class="btn btn-primary si">Si</button>
        </div>
    </div>
