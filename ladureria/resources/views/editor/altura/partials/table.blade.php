<div class="table-responsive">
    <table class="table table-bordered">
    <tr>
        @foreach ($fields as $field)
        <th>{{$field->etiqueta}}</th>
        @endforeach
        <th>Acciones</th>
        @if ($datos["traducir"])<th>Traducciones</th>@endif
    </tr>
    <?php $referencia=$datos["nombre"];?>
    @foreach($registros as $registro)
        <?php $class='default'; ?>
        @if ($datos["traducir"])
            @foreach($locales as $locale)
                @if (isset($registro->translate($locale->language)->$referencia))
                    @if ($registro->translate($locale->language)->actualizado==1)
                        <?php $class.=' '.$locale->language.'-f';?>
                    @endif
                @endif
            @endforeach
        @endif
        <tr class="{{$class}}" data-id="{{$registro->id}}">
            @foreach ($fields as $field)
            <?php $campo=$field->field; ?>
                @if ($field->mostrar=='text')
                    <td>{!!$registro->$campo!!}</td>
                @elseif ($field->mostrar=='imagen')
                    <td>@if ($registro->$campo!='') <a href="#" class="popi" title="click para agrandar la imagen">{!! Html::image($registro->$campo,$registro->$referencia,['class'=>'img-responsive','width'=>'100%']) !!}</a> @else <b style="color:red;">sin imagen</b> @endif</td>
                @elseif ($field->mostrar=='options')
                    <td>@if ($registro->$campo==0) <b style="color:red;">No</b> @else <b style="color:green;">Si</b> @endif</td>
                @elseif ($field->mostrar=='relacion')
                    <td>@foreach ($field->valor as $ruta) <?php $partes=explode('->',$ruta); $aux=$registro; ?> @foreach ($partes as $p) <?php $aux=$aux->$p; ?>  @endforeach {{$aux}} , @endforeach</td>
                @endif
            @endforeach
            <td>
                @if ($datos["edit"])<p><a href="{{route('editor.altura.catblog.edit',['id'=>$registro->id,'model'=>$modelo])}}" title="click para editar informacion de {{$registro->$referencia}}"><span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span> Edit</a></p>@endif
                @if ($datos["delete"])
                <p>
                    {!! Form::open(['route'=> ['editor.altura.catblog.destroy',$registro], 'method'=>'DELETE']) !!}
                    {!! Form::hidden('model', $modelo) !!}
                    <button type="submit" onclick="return confirm('Seguro que desea eliminar el elemento {{$registro->$referencia}}')" class="btn btn-danger" title="eliminar {{$registro->$referencia}}"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar</button>
                    {!! Form::close() !!}
                </p>
                @endif
            </td>
            @if ($datos["traducir"])
            <td>
                <div class="well">
                    @foreach($locales as $locale)
                        @if (isset($registro->translate($locale->language)->$referencia))
                            @if ($registro->translate($locale->language)->actualizado==1)
                                <a id="{{$registro->id}}-{{$locale->language}}" href="#!" title="La información esta traducida al {{$locale->titulo}} correctamente, click para ver" data-target="#myModal" class="traduccion" data-idc="{{$registro->id}}" data-idl="{{$locale->id}}" data-ido="ua" style="color: green;"><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: green;"></span> {{$locale->titulo}}</a>
                            @else
                                <a id="{{$registro->id}}-{{$locale->language}}" href="#!" title="La traducción al {{$locale->titulo}} esta desactualizada, click para actualizar" data-target="#myModal" class="traduccion" data-idc="{{$registro->id}}" data-idl="{{$locale->id}}" data-ido="u" style="color: blue;"><span class="glyphicon glyphicon-refresh" aria-hidden="true" style="color: blue;"></span> {{$locale->titulo}}</a>
                            @endif
                        @else
                            <a id="{{$registro->id}}-{{$locale->language}}" href="#!" title="No existe traducción en {{$locale->titulo}}, click para traducir" data-target="#myModal" class="traduccion" data-idc="{{$registro->id}}" data-idl="{{$locale->id}}" data-ido="u" style="color: red;"><span class="glyphicon glyphicon-plus" aria-hidden="true" style="color: red;"></span> {{$locale->titulo}}</a>
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

<div id="myModal" class="modal fade" tabindex="1" data-width="60%" style="display: none;"></div>

<div id="imagemodal" class="modal fade" tabindex="1" data-width="760" style="display: none;">
    <div class="modal-content">
        <div class="modal-body">
            <img src="" class="imagepreview" style="width: 100%;" >
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
        </div>
    </div>
</div>