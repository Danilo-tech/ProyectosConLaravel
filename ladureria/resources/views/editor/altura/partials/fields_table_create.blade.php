@if (count($laterales)>0) <div class="col-md-8" style="border-right: solid 1px #CCCCCC;"> @endif
{!!Form::hidden('modelo',$modelo, ['class'=>'form-control'])!!}
@if (isset($padre))
    {!!Form::hidden('padre',$padre, ['class'=>'form-control'])!!}
    {!!Form::hidden('padre_model',$padre_model, ['class'=>'form-control'])!!}
@endif
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