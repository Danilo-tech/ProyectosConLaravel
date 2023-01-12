@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="page-header">
                    <h1>{{$datos["cabecera"]}}</h1>
                </div>
                @if (isset($padre))
                    <ol class="breadcrumb">
                        <li><a href="{{route('editor.altura.catblog.index',['model'=>$padre_model])}}">Listar {{$padre_datos["cabecera"]}}</a></li>
                        <?php $r=$padre_datos["nombre"];?>
                        <li><a href="{{route('editor.altura.catblog.edit',['id'=>$padre,'model'=>$padre_model])}}">{{$padre_info->$r}}</a></li>
                        <li class="active">Editar</li>
                    </ol>
                @else
                <ol class="breadcrumb">
                    <li><a href="{{route('editor.altura.catblog.index',['model'=>$modelo])}}">Listar {{$datos["cabecera"] }}</a></li>
                    <li class="active">Editar</li>
                </ol>
                @endif
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <blockquote>
                            <?php $referencia=$datos["nombre"];?>
                            <p>Editar {{$model_data->$referencia}}</p>
                            <footer style="color: white;"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> Campos obligatorios</footer>
                            <footer style="color: white;"><span class="glyphicon glyphicon-flag" aria-hidden="true"></span> Campos traducidos</footer>
                        </blockquote>
                    </div>
                    <div class="panel-body">
                        @include('editor.altura.partials.messages')
                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                <p>Se completaron las siguientes peticiones:</p>
                                <ul>
                                    <li>{{Session::get('message')}}</li>
                                </ul>
                            </div>
                        @endif
                        {!! Form::model($model_data, ['route'=>['editor.altura.catblog.update',$model_data], 'method'=>'PUT', 'id'=>'formtable', 'files' => true]) !!}
                        @include('editor.altura.partials.fields_table_update')
                        <input name="actualizado_general" id="actualizado_general" type="checkbox" value="1" style="display:none;">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        @if (count($laterales)>0)
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    @foreach ($laterales as $lat)
                                        <div class="well">
                                            <h4>{{$lat->titulo}}</h4>
                                            <div class="form-group" data-toggle="popover" id="pa">
                                                <?php $i=0; $elementos_actuales=array(); $funcion=$lat->funcion; $cantidades_actuales=array(); $ids_actuales=array(); $ref_cantidad="simple";?>
                                                @foreach ($model_data->$funcion as $el)
                                                    <?php $secundario=$lat->secundario; ?>
                                                    @if ($lat->tipo=="cantidad") <?php $ref_cantidad=$lat->cantidad; ?> @else <?php $ref_cantidad="simple"; ?>  @endif
                                                    <?php $elementos_actuales[$i]= $el->$secundario; if ($lat->tipo=="cantidad"){ $cantidades_actuales[$i]= $el->$ref_cantidad; $ids_actuales[$i]=$el->id; } $i=$i+1;?>
                                                @endforeach
                                                <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
                                                @foreach ($lat->data as $elemento)
                                                    <?php $referencia=$lat->modeldata["nombre"];?>
                                                    <div class="checkbox checkbox-info">
                                                        <input id="{{$lat->funcion}}-{{$elemento->id}}" data-ide="{{$ref_cantidad}}" data-idf="{{$lat->funcion}}" class="cb_cb" data-idm="{{$lat->union}}" @if ($lat->tipo=="cantidad") data-idt="cantidad" @else data-idt="simple" @endif name="{{$lat->funcion}}[]" type="checkbox" value="{{$elemento->id}}" @if (in_array($elemento->id, $elementos_actuales)) checked @endif>
                                                        <label for="{{$lat->funcion}}-{{$elemento->id}}" style="font-size: 12px;"> {{$elemento->$referencia}} </label>
                                                        @if ($lat->tipo=="cantidad")
                                                            @if (in_array($elemento->id, $elementos_actuales))
                                                                <?php $clave=array_search($elemento->id, $elementos_actuales); $cantidad=$cantidades_actuales[$clave]; $id_actual= $ids_actuales[$clave]?>
                                                                <span id="cantidad-{{$lat->funcion}}-{{$elemento->id}}" style="font-size: 12px;"> - {{$ref_cantidad}}
                                                                <span style="font-size: 12px;" title="Click para editar valor {{$elemento->$referencia}}">:<a href="#" class="cantidad" data-idm="{{$lat->union}}" data-pk="{{$id_actual}}" data-name="{{$ref_cantidad}}" data-url="{{route('update-cantidad-tabla')}}" data-title="Ingresar nuevo valor" style="font-size: 12px;">{{$cantidad}}</a></span></span>
                                                            @else
                                                                <span id="cantidad-{{$lat->funcion}}-{{$elemento->id}}" style="font-size: 12px;">&nbsp;</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        {!! Form::close() !!}
                    </div>
                </div>

                <?php $i=1;?>
                @if (count($cuerpos)>0)
                    @foreach($cuerpos as $cuerpo)
                        @if ($cuerpo->tipo=='multimedia' || $cuerpo->tipo=='galeria')
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <blockquote>
                                    <p>{{$cuerpo->titulo}}</p>
                                    <?php $referencia=$datos["nombre"];?>
                                    <?php $funcion=$cuerpo->funcion;?>
                                    <footer style="color: white;"><b>{{$model_data->$referencia}}</b>, tiene <span class="badge">{{count($model_data->$funcion)}}</span> recurso(s)</footer>
                                </blockquote>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="well">
                                        {!! Form::open(['route'=>'editor.altura.multimediablog.store', 'method'=>'POST', 'files' => true]) !!}
                                        <label class="control-label" style="color: #337ab7;"><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar Imagen(es) - {{$cuerpo->validar[0]}} ( max {{$cuerpo->validar[1]}} )</label>
                                        <input name="imagen[]" type="file" multiple=true id="imagen_multiple{{$i}}" class="file-loading">
                                        {!! Form::hidden('principal_id', $model_data->id) !!}
                                        {!! Form::hidden('modelo', $cuerpo->modelo) !!}
                                        {!! Form::close() !!}

                                        @if ($cuerpo->tipo=='multimedia')
                                            <h3>OR </h3>
                                            {!! Form::open(['route'=>'editor.altura.multimediablog.store', 'method'=>'POST', 'id' => 'multimedia']) !!}
                                            <div class="form-group">
                                                {!!Form::label('urlvideo' ,'Multimedia (Embed)', ['class'=>'control-label'])!!}
                                                <div class="input-group">
                                                    <span class="input-group-addon"><abbr title="Este campo es obligatorio"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></abbr></span>
                                                    <div>
                                                        {!!Form::text('urlvideo', null, ['class'=>'form-control'])!!}
                                                        {!! Form::hidden('principal_id', $model_data->id) !!}
                                                        {!! Form::hidden('modelo', $cuerpo->modelo) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Registrar Multimedia</button>
                                            </div>
                                            {!! Form::close() !!}
                                            <h3>OR </h3>
                                            {!! Form::open(['route'=>'editor.altura.multimediablog.store', 'method'=>'POST', 'id' => 'multimedia']) !!}
                                            <div class="form-group">
                                                {!!Form::label('urlenlace' ,'Vinculos Relacionados (Url)', ['class'=>'control-label'])!!}
                                                <div class="input-group">
                                                    <span class="input-group-addon"><abbr title="Este campo es obligatorio"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></abbr></span>
                                                    <div>
                                                        {!!Form::text('urlenlace', null, ['class'=>'form-control'])!!}
                                                        {!! Form::hidden('principal_id', $model_data->id) !!}
                                                        {!! Form::hidden('modelo', $cuerpo->modelo) !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Registrar Vinculo</button>
                                            </div>
                                            {!! Form::close() !!}
                                        @endif

                                    </div>

                                    <div class="table-responsive" >
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Recurso</th>
                                                <th>Acciones</th>
                                            </tr>

                                            @foreach($model_data->$funcion as $imagen)
                                                <tr data-id="{{$imagen->id}}">
                                                    <td>
                                                        <div>
                                                            <blockquote>
                                                                @if ($imagen->imagen !='')
                                                                    <p><a href="#" class="popi" alt="click to open image">{!! Html::image($imagen->imagen,$imagen->leyenda,['width'=>'200','class'=>'img-responsive img-thumbnail']) !!}</a></p>
                                                                @elseif ($imagen->urlvideo !='')
                                                                    <p><div class="embed-responsive embed-responsive-4by3">{!!$imagen->urlvideo!!}</div></p>
                                                                @elseif ($imagen->urlenlace !='')
                                                                    <p><div style="height: auto;">Url:{!!$imagen->urlenlace!!}</div></p>
                                                                @endif
                                                                <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
                                                                <footer><span id="texto-imagen-{{$imagen->id}}-es-tour" style="font-size: 12px; color: green;"><span id="icon-imagen-{{$imagen->id}}-es-tour" class="glyphicon glyphicon-ok" aria-hidden="true" style="color: green;"></span> (Español) </span><a href="#" class="leyendam" data-pk="es" data-name="leyenda" data-url="{{route('editor.altura.multimediablog.update',['id'=>$imagen->id,'model'=>$cuerpo->modelo])}}" data-title="Ingresar Leyenda">{{$imagen->leyenda}}</a></footer>
                                                                @foreach($locales as $locale)
                                                                    @if (isset($imagen->translate($locale->language)->leyenda))
                                                                        @if ($imagen->translate($locale->language)->actualizado==1)
                                                                            <footer><span id="texto-imagen-{{$imagen->id}}-{{$locale->language}}-tour" style="font-size: 12px; color: green;"><span id="icon-imagen-{{$imagen->id}}-{{$locale->language}}-tour" class="glyphicon glyphicon-ok" aria-hidden="true" style="color: green;"></span> ({{$locale->titulo}}) </span><a href="#" class="leyendam" data-pk="{{$locale->language}}" data-name="leyenda" data-url="{{route('editor.altura.multimediablog.update' ,['id'=>$imagen->id,'model'=>$cuerpo->modelo])}}" data-title="Ingresar Leyenda">{{$imagen->translate($locale->language)->leyenda}}</a></footer>
                                                                        @else
                                                                            <footer><span id="texto-imagen-{{$imagen->id}}-{{$locale->language}}-tour" style="font-size: 12px; color: blue;"><span id="icon-imagen-{{$imagen->id}}-{{$locale->language}}-tour" class="glyphicon glyphicon-refresh" aria-hidden="true" style="color: blue;"></span> ({{$locale->titulo}}) </span><a href="#" class="leyendam" data-pk="{{$locale->language}}" data-name="leyenda" data-url="{{route('editor.altura.multimediablog.update',['id'=>$imagen->id,'model'=>$cuerpo->modelo])}}" data-title="Ingresar Leyenda">{{$imagen->translate($locale->language)->leyenda}}</a></footer>
                                                                        @endif
                                                                    @else
                                                                        <footer><span id="texto-imagen-{{$imagen->id}}-{{$locale->language}}-tour" style="font-size: 12px; color: red;"><span id="icon-imagen-{{$imagen->id}}-{{$locale->language}}-tour" class="glyphicon glyphicon-plus" aria-hidden="true" style="color: red;"></span> ({{$locale->titulo}}) </span><a href="#" class="leyendam" data-pk="{{$locale->language}}" data-name="leyenda" data-url="{{route('editor.altura.multimediablog.update',['id'=>$imagen->id,'model'=>$cuerpo->modelo])}}" data-title="Ingresar Leyenda">sin leyenda</a></footer>
                                                                    @endif
                                                                @endforeach

                                                            </blockquote>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($cuerpo->datos["delete"])
                                                            {!! Form::open(['route'=> ['editor.altura.multimediablog.destroy',$imagen], 'method'=>'DELETE']) !!}
                                                            {!! Form::hidden('model', $cuerpo->modelo) !!}
                                                            <button type="submit" onclick="return confirm('Seguro que desea eliminar el recurso {{$imagen->leyenda}}')" class="btn btn-danger">Eliminar Recurso</button>
                                                            {!! Form::close() !!}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif ($cuerpo->tipo=='datos')
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <blockquote>
                                        <p>{{$cuerpo->titulo}}</p>
                                        <?php $referencia=$datos["nombre"];?>
                                        <?php $funcion=$cuerpo->funcion;?>
                                        <footer style="color: white;"><b>{{$model_data->$referencia}}</b>, tiene <span class="badge">{{count($model_data->$funcion)}}</span> elemento(s)</footer>
                                    </blockquote>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        @if ($cuerpo->datos["registrar"])<p><a class="btn btn-success" href="{{route('editor.altura.catblog.create',['model'=>$cuerpo->modelo, 'padre'=>$model_data->id, 'model_padre'=>$modelo])}}" role="button">Registrar Elemento</a></p>@endif
                                        <div class="table-responsive" >
                                            <table class="table table-bordered">
                                                <tr>
                                                    @foreach ($cuerpo->fields as $field)
                                                        <th>{{$field->etiqueta}}</th>
                                                    @endforeach
                                                    <th>Acciones</th>
                                                    @if ($cuerpo->datos["traducir"])<th>Traducciones</th>@endif
                                                </tr>
                                                <?php $referencia=$cuerpo->datos["nombre"];?>
                                                @foreach($model_data->$funcion as $area)
                                                    <tr data-id="{{$area->id}}">
                                                        @foreach ($cuerpo->fields as $field)
                                                            <?php $campo=$field->field; ?>
                                                            @if ($field->mostrar=='text')
                                                                <td>{!!$area->$campo!!}</td>
                                                            @elseif ($field->mostrar=='imagen')
                                                                <td>@if ($area->$campo!='') <a href="#" class="popi" title="click para agrandar la imagen">{!! Html::image($area->$campo,$area->$referencia,['class'=>'img-responsive','width'=>'100%']) !!}</a> @else <b style="color:red;">sin imagen</b> @endif</td>
                                                            @elseif ($field->mostrar=='options')
                                                                <td>@if ($area->$campo==0) <b style="color:red;">No</b> @else <b style="color:green;">Si</b> @endif</td>
                                                            @elseif ($field->mostrar=='relacion')
                                                                <td>@foreach ($field->valor as $ruta) <?php $partes=explode('->',$ruta); $aux=$area; ?> @foreach ($partes as $p) <?php $aux=$aux->$p; ?>  @endforeach {{$aux}} , @endforeach</td>
                                                            @endif
                                                        @endforeach
                                                        <td>
                                                            @if ($cuerpo->datos["edit"])<p><a href="{{route('editor.altura.catblog.edit',['id'=>$area->id,'model'=>$cuerpo->modelo, 'padre'=>$model_data->id, 'model_padre'=>$modelo])}}" title="click para editar informacion de {{$area->$referencia}}"><span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a></p>@endif
                                                            @if ($cuerpo->datos["delete"])
                                                            <p>
                                                                {!! Form::open(['route'=> ['editor.altura.catblog.destroy',$area], 'method'=>'DELETE']) !!}
                                                                {!! Form::hidden('model', $cuerpo->modelo) !!}
                                                                <button type="submit" onclick="return confirm('Seguro que desea eliminar el elemento {{$area->$referencia}}')" class="btn btn-danger" title="eliminar {{$area->$referencia}}"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar</button>
                                                                {!! Form::close() !!}
                                                            </p>
                                                            @endif
                                                        </td>
                                                        @if ($cuerpo->datos["traducir"])
                                                            <td>
                                                                <div class="well">
                                                                    @foreach($locales as $locale)
                                                                        @if (isset($area->translate($locale->language)->$referencia))
                                                                            @if ($area->translate($locale->language)->actualizado==1)
                                                                                <a id="{{$area->id}}-{{$locale->language}}" href="#!" title="La información esta traducida al {{$locale->titulo}} correctamente, click para ver" data-target="#myModal" class="traduccion" data-idm="{{$cuerpo->modelo}}" data-idc="{{$area->id}}" data-idl="{{$locale->id}}" data-ido="ua" style="color: green;"><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: green;"></span> {{$locale->titulo}}</a>
                                                                            @else
                                                                                <a id="{{$area->id}}-{{$locale->language}}" href="#!" title="La traducción al {{$locale->titulo}} esta desactualizada, click para actualizar" data-target="#myModal" class="traduccion" data-idm="{{$cuerpo->modelo}}" data-idc="{{$area->id}}" data-idl="{{$locale->id}}" data-ido="u" style="color: blue;"><span class="glyphicon glyphicon-refresh" aria-hidden="true" style="color: blue;"></span> {{$locale->titulo}}</a>
                                                                            @endif
                                                                        @else
                                                                            <a id="{{$area->id}}-{{$locale->language}}" href="#!" title="No existe traducción en {{$locale->titulo}}, click para traducir" data-target="#myModal" class="traduccion" data-idm="{{$cuerpo->modelo}}" data-idc="{{$area->id}}" data-idl="{{$locale->id}}" data-ido="u" style="color: red;"><span class="glyphicon glyphicon-plus" aria-hidden="true" style="color: red;"></span> {{$locale->titulo}}</a>
                                                                        @endif
                                                                        <br>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    @endforeach
                @endif

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var indice_imagen=1;
        var indice_imagen_cuerpo=1;
        var actualizar_traduccion=0;
        var campos_traducir="";
        $(document).ready(function() {

            var $modal1 = $('#myModalConfirm');
            @foreach ($fields as $field)
                @if ($field->traducir)
                    campos_traducir=campos_traducir+'#'+'{{$field->field}}'+',';
                @endif
            @endforeach
            campos_traducir=campos_traducir.slice(0,-1);
            $(campos_traducir).on('change', function(){
                actualizar_traduccion=1;
            })

            $('.popi').on('click', function(e) {
                e.preventDefault();
                $('body').modalmanager('loading');
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });

            $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner =
                    '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
                    '<div class="progress progress-striped active">' +
                    '<div class="progress-bar" style="width: 100%;">Cargando</div>' +
                    '</div>' +
                    '</div>';

            $.fn.modalmanager.defaults.resize = true;

            @foreach ($fields as $field)
                @if ($field->mostrar=="imagen")
                $("#imagen"+indice_imagen).fileinput({
                    language: 'es',
                    showCaption: false,
                    allowedFileTypes:['image'],
                    maxFileSize: '{{$field->validacion[1]}}',
                    showCaption: false,
                    showRemove: false,
                    showUpload: false,
                    browseLabel: "Cambiar imagen",
                    browseClass: "btn btn-success"
                });
                indice_imagen=indice_imagen+1;
                @endif
            @endforeach

            @foreach ($cuerpos as $cuerpo)
                @if ($cuerpo->tipo=="multimedia" || $cuerpo->tipo=="galeria")
                $("#imagen_multiple"+indice_imagen_cuerpo).fileinput({
                    language: 'es',
                    showCaption: false,
                    allowedFileTypes:['image'],
                    maxFileSize: '{{$cuerpo->validar[1]}}',
                    browseLabel: "Selecionar imagen(es)"
                });
                indice_imagen_cuerpo=indice_imagen_cuerpo+1;
                @endif
            @endforeach

            $(".updown").TouchSpin({
                verticalbuttons: true,
                initval: 1,
                min:1
            });

            $('.cb_cb').on('click', function(){
                // create the backdrop and wait for next modal to be triggered
                var accion='';
                var idelemento=$(this).val();
                var modelo=$(this).data('idm');
                var funcion=$(this).data('idf');
                var tipo=$(this).data('idt');
                var etiqueta=$(this).data('ide');

                $('body').modalmanager('loading');
                if($(this).is(':checked')) {
                    var url = '{{route('create-elemento-cb',[':idp',':ids',':idm'])}}';
                    accion='insert';
                }
                else {
                    var url = '{{route('delete-elemento-cb',[':idp',':ids',':idm'])}}';
                    accion='delete';
                }
                url = url.replace(':idp','{{$model_data->id}}');
                url = url.replace(':ids', idelemento);
                url = url.replace(':idm', modelo);
                $.get(url, function(response) {
                    $('body').modalmanager('loading');
                    console.log(response.identificador);
                    if (tipo == "cantidad"){
                        if (accion == 'insert') {
                            $('#cantidad-'+funcion+'-'+idelemento).append(' - '+etiqueta+'<span style="font-size: 12px;" title="Click para editar valor">:<a href="#" class="cantidad" data-idm="' +modelo+ '" data-pk="' + response.identificador + '" data-name="' +etiqueta+ '" data-url="{{route('update-cantidad-tabla')}}" data-title="Ingresar nuevo valor" style="font-size: 12px;">1</a></span>');
                            $.fn.editable.defaults.mode = 'popup';
                            $.fn.editable.defaults.ajaxOptions = {type: "POST", dataType: 'json'};
                            $('.cantidad').editable({
                                validate: function(value) {
                                    if($.trim(value) == '')
                                        return 'Este campo es oblicatorio';
                                },
                                success: function(response, newValue)
                                {
                                    toastr["success"](response.mensaje, response.titulo);
                                },
                                error: function(response, newValue)
                                {
                                    if(response.status === 500) {
                                        return 'Service unavailable. Please try later.';
                                    } else {
                                        return response.responseText;
                                    }
                                },
                                params: function(params) {
                                    //originally params contain pk, name and value
                                    params._token = $("#_token").data("token");
                                    params.model = modelo;
                                    return params;
                                }
                            });
                        }
                        else {
                            $('#cantidad-'+funcion+'-'+idelemento).empty();
                        }
                    }
                    toastr["success"](response.mensaje, response.titulo);
                }).fail(function(data)
                {
                    $('body').modalmanager('loading');
                    var errors = $.parseJSON(data.responseText);
                    console.log(errors);
                    $.each(errors, function(index, value) {
                        //info.find('ul').append(value);
                        toastr["error"](value, 'ERROR');
                    });
                });
            });



            $.fn.editable.defaults.mode = 'popup';
            $.fn.editable.defaults.ajaxOptions = {type: "PUT", dataType: 'json'};
            $.fn.editable.defaults.params = function (params) {
                params._token = $("#_token").data("token");
                return params;
            };
            $('.leyendam').editable({
                validate: function(value) {
                    if($.trim(value) == '')
                        return 'Este campo es obligatorio';
                },
                success: function(response, newValue)
                {
                    //userModel.set('leyenda', newValue); //update backbone model
                    toastr["success"](response.mensaje, response.titulo);
                    $("#texto-imagen-"+response.imagen+"-"+response.idioma+"-"+response.nombre).css("color", "green");
                    $("#icon-imagen-"+response.imagen+"-"+response.idioma+"-"+response.nombre).removeClass("glyphicon-plus");
                    $("#icon-imagen-"+response.imagen+"-"+response.idioma+"-"+response.nombre).removeClass("glyphicon-refresh");
                    $("#icon-imagen-"+response.imagen+"-"+response.idioma+"-"+response.nombre).addClass("glyphicon-ok");
                    $("#icon-imagen-"+response.imagen+"-"+response.idioma+"-"+response.nombre).css("color", "green");
                },
                error: function(response, newValue)
                {
                    if(response.status === 500) {
                        return 'Service unavailable. Please try later.';
                    } else {
                        return response.responseText;
                    }
                }
            });

            $.fn.editable.defaults.mode = 'popup';
            $.fn.editable.defaults.ajaxOptions = {type: "POST", dataType: 'json'};

            $('.cantidad').editable({
                validate: function(value) {
                 if($.trim(value) == '')
                 return 'Este campo es oblicatorio';
                },
                success: function(response, newValue)
                {
                    toastr["success"](response.mensaje, response.titulo);
                },
                error: function(response, newValue)
                {
                    if(response.status === 500) {
                        return 'Service unavailable. Please try later.';
                    } else {
                        return response.responseText;
                    }
                },
                params: function(params) {
                    //originally params contain pk, name and value
                    params._token = $("#_token").data("token");
                    params.model = $(this).data('idm');
                    return params;
                }
            });

            var $modal = $('#myModal');
            $('.traduccion').on('click', function(){
                // create the backdrop and wait for next modal to be triggered
                $('body').modalmanager('loading');
                var idelemento = $(this).data('idc');
                var idlanguage = $(this).data('idl');
                var operacion = $(this).data('ido');
                var modelo = $(this).data('idm');
                var url = '{{ route("tabla-traductor", [':idc',':idl',':ido',':idm']) }}';
                url = url.replace(':idc', idelemento);
                url = url.replace(':idl', idlanguage);
                url = url.replace(':ido', operacion);
                url = url.replace(':idm', modelo);
                setTimeout(function(){
                    $modal.load(url, '', function(){
                        $modal.modal('toggle');
                    });
                }, 1000);
            });

            $('#formtable').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    @foreach ($fields as $field)
                        @if (count($field->validacion))
                        '{{$field->field}}': {
                            validators: {
                                @foreach ($field->validacion as $valid)
                                    @if ($valid=='required')
                                    notEmpty: {
                                        message: 'Este campo es obligatorio'
                                    },
                                    @endif
                                @endforeach
                            }
                        },
                        @endif
                    @endforeach
                }
            }).on('success.form.bv', function(e) {
                if (actualizar_traduccion==1)
                {
                    e.preventDefault();
                    $modal1.modal('toggle');
                    $modal1.on('click', '.no', function(){
                        $('body').modalmanager('loading');
                        setTimeout(function(){
                            var $form = $(e.target),
                                    bv = $form.data('bootstrapValidator');
                            bv.defaultSubmit();
                        }, 1000);
                    });
                    $modal1.on('click', '.si', function(){
                        $('body').modalmanager('loading');
                        setTimeout(function(){
                            $('#actualizado_general').attr('checked', true);
                            var $form = $(e.target),
                                    bv = $form.data('bootstrapValidator');
                            bv.defaultSubmit();
                        }, 1000);
                    });
                }
            });

            $('#multimedia').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    urlvideo: {
                        validators: {
                            notEmpty: {
                                message: 'Este campo es obligatorio'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection