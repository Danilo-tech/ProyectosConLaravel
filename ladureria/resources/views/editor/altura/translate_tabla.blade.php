<div class="modal-header" style="background-color: #337ab7;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" style="color: white;">Traducción {{$datos["cabecera"]}}</h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-info" role="alert" style="font-size: 12px;">
                Última actualizacion v.Español {{$modelo_data->translate('en')->updated_at}}
                @if ($operacion!='ua')
                    <br><b>Referencia: </b> Estan resaltados los últimos cambios:
                    <ul>
                        <li>Información agregada - fondo verder y subrayado</li>
                        <li>Información eliminada - fondo rojo y tachado</li>
                    </ul>
                @endif
            </div>
            <h4>Original (Español)</h4>
            @if ($operacion!='ua')
                @foreach ($fields as $old)
                    <p><b>{{$old->etiqueta}}:</b><br><span style="font-size:13px;">{!!$old->valor_old!!}</span></p>
                @endforeach
            @else
                @foreach ($fields as $valor)
                    <?php $a=$valor->valor; ?>
                    <p><b>{{$valor->etiqueta}}:</b><br>{{$modelo_data->$a}} </p>
                @endforeach
            @endif
        </div>
        <div class="col-md-6" style="border-left: 1px solid #CCCCCC;">
            <div class="alert alert-info" role="alert" style="font-size: 12px;">
                Última actualizacion v.{{$locale->titulo}} {{$modelo_data->translate($locale->language)->updated_at}}
            </div>
            <h4>Traduccion ({{$locale->titulo}})</h4>
            {!! Form::open(['route'=>['editor.altura.catblog.update',$modelo_data], 'id'=>'form-traductor', 'method'=>'PUT', 'role'=>'form']) !!}
            <div class="alert alert-danger" id="ajax-alert-modal" role="alert" style="display: none">
                <ul></ul>
            </div>
            <?php $i=1; ?>
            @foreach ($fields as $field)
                <?php $a=$field->valor; ?>
                <div class="form-group">
                    {!!Form::label($a ,$field->etiqueta)!!}
                    @if ($field->tipo=="varchar")
                        {!!Form::text($a, $modelo_data->translate($locale->language)->$a, ['class'=>'form-control'])!!}
                    @else
                        @if (in_array("ckeditor", $field->validar))
                            {!!Form::textarea($a, $modelo_data->translate($locale->language)->$a, ['class'=>'form-control', 'id'=>'editor'.$i])!!}
                            <script>
                                CKEDITOR.replace('editor'+'{{$i}}');
                            </script>
                            <?php $i=$i+1; ?>
                        @else
                            {!!Form::textarea($a, $modelo_data->translate($locale->language)->$a, ['class'=>'form-control'])!!}
                        @endif
                    @endif
                </div>
            @endforeach
            {!!Form::hidden('language', $locale->language, ['class'=>'form-control'])!!}
            {!!Form::hidden('elemento_id', $modelo_data->id, ['class'=>'form-control'])!!}
            {!!Form::hidden('locale_id', $locale->id, ['class'=>'form-control'])!!}
            {!!Form::hidden('language_titulo', $locale->titulo, ['class'=>'form-control'])!!}
            {!!Form::hidden('modelo', $modelo, ['class'=>'form-control'])!!}
            <div class="form-group">
                @if ($operacion=='ua')
                    <div class="alert alert-success" role="alert">
                        <div class="checkbox checkbox-success">
                            {!!Form::checkbox('actualizado', '1', true,['id'=>'actualizado'])!!}
                            @else
                                <div class="well">
                                    <div class="checkbox checkbox-success">
                                        {!!Form::checkbox('actualizado', '1', false,['id'=>'actualizado'])!!}
                                        @endif
                                        <label for="actualizado">He terminado de traducir y/o actualizar</label>
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
            <button type="submit" class="btn btn-primary send-btn">Actualizar</button>
            {!! Form::close() !!}
        </div>


        <script>
            $(document).ready(function(){
                $('.send-btn').click(function(e){
                    var $modal = $('#myModal');
                    $modal.modal('loading');
                    var info = $('#ajax-alert-modal');
                    info.hide().find('ul').empty();
                    var $form = $('#form-traductor');
                    e.preventDefault();
                    var url = $form.attr('action');
                    var formData = {};
                    for ( instance in CKEDITOR.instances )
                    {
                        CKEDITOR.instances[instance].updateElement();
                    }
                    //submit a POST request with the form data
                    $form.find('input, select, textarea').each(function()
                    {
                        formData[ $(this).attr('name') ] = $(this).val();
                    });
                    if($("#actualizado").is(':checked'))
                        formData['actualizado']=1;
                    else
                        formData['actualizado']=0;
                    //alert(formData['actualizado']);
                    $.post(url, formData, function(response)
                    {
                        toastr.options = {
                            "newestOnTop": true,
                            "progressBar": true,
                            "positionClass": "toast-top-right",
                            "showDuration": "4000",
                            "hideDuration": "4000",
                            "timeOut": "4000",
                            "extendedTimeOut": "4000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                        toastr["success"](response.mensaje, response.titulo);
                        $('#myModal').modal('hide');
                        var cadena=response.elemento+'-'+response.idioma;
                        $('#'+cadena).empty();
                        if (response.actualizado==1) {
                            var fila=$('#'+cadena).parents('tr');
                            fila.addClass(response.idioma+"-f");
                            $('#'+cadena).data('ido','ua');
                            $('#'+cadena).append('<span class="glyphicon glyphicon glyphicon-ok" aria-hidden="true" style="color: green;"></span> ' + response.language_titulo).fadeIn();
                            $('#'+cadena).css("color", "green");
                            $('#'+cadena).attr("title","La información esta traducida al "+response.language_titulo+" correctamente, click para ver");
                        }
                        else {
                            var fila=$('#'+cadena).parents('tr');
                            fila.removeClass(response.idioma+"-f");
                            $('#'+cadena).data('ido','u');
                            $('#'+cadena).append('<span class="glyphicon glyphicon glyphicon-refresh" aria-hidden="true" style="color: blue;"></span> ' + response.language_titulo).fadeIn();
                            $('#'+cadena).css("color", "blue");
                            $('#'+cadena).attr("title","La traducción al "+response.language_titulo+" esta desactualizada, click para actualizar");
                        }
                        //alert(response.actualizado);
                    }).fail(function(data)
                    {
                        $modal.modal('loading');
                        var errors = $.parseJSON(data.responseText);
                        console.log(errors);
                        $.each(errors, function(index, value) {
                            info.find('ul').append(value);
                        });
                        info.slideDown();
                    });
                });



            });
        </script>


