<div class="table-responsive">
    <table class="table table-bordered">
    <tr>
        <th>Nombre</th>
        <th>Daily descriptions Incluidos</th>
        <th>Prices</th>
        <th>Options</th>
        <th>Translations</th>
    </tr>
    @foreach($trip as $trip)
        <?php $class='default';?>
        @foreach($locales as $locale)
            @if (isset($trip->translate($locale->language)->nombre))
                @if ($trip->translate($locale->language)->actualizado==1)
                    <?php $class.=' '.$locale->language.'-f';?>
                @endif
            @endif
        @endforeach
        <tr class="{{$class}}" data-id="{{$trip->id}}">
            <td>{{$trip->nombre}}<br><b>Agrupado con tag: </b>{{$trip->agrupar}}</td>
            <td>@foreach($trip->tourtrip as $tourtrip)
                {{$tourtrip->tour->nombre}}<br>
                @endforeach

            </td>
            <td>
                @foreach ($trip->levels as $level)
                    <b>{{$level->level->level}}</b>: ${{$level->precio}}<br>
                @endforeach
            </td>

            <td>
                <p><a href="{{route('editor.altura.trip.edit', $trip)}}" title="click para editar informacion de {{$trip->nombre}}"><span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</a></p>
                <p>
                    {!! Form::open(['route'=> ['editor.altura.trip.destroy',$trip], 'method'=>'DELETE']) !!}
                    <button type="submit" onclick="return confirm('seguro que desea eliminar el tour package {{$trip->nombre}}')" class="btn btn-danger" title="eliminar tour package {{$trip->nombre}}"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span>Eliminar</button>
                    {!! Form::close() !!}</p>
            </td>
            <td>
                <div class="well">
                    @foreach($locales as $locale)
                        @if (isset($trip->translate($locale->language)->nombre))
                            @if ($trip->translate($locale->language)->actualizado==1)
                                <a id="{{$trip->id}}-{{$locale->language}}" href="#!" title="La información esta traducida al {{$locale->titulo}} correctamente, click para ver" data-target="#myModal" class="traduccion" data-idt="{{$trip->id}}" data-idl="{{$locale->id}}" data-ido="ua" style="color: green;"><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: green;"></span> {{$locale->titulo}}</a>
                            @else
                                <a id="{{$trip->id}}-{{$locale->language}}" href="#!" title="La traducción al {{$locale->titulo}} esta desactualizada, click para actualizar" data-target="#myModal" class="traduccion" data-idt="{{$trip->id}}" data-idl="{{$locale->id}}" data-ido="u" style="color: blue;"><span class="glyphicon glyphicon-refresh" aria-hidden="true" style="color: blue;"></span> {{$locale->titulo}}</a>
                            @endif
                        @else
                            <a id="{{$trip->id}}-{{$locale->language}}" href="#!" title="No existe traducción en {{$locale->titulo}}, click para traducir" data-target="#myModal" class="traduccion" data-idt="{{$trip->id}}" data-idl="{{$locale->id}}" data-ido="u" style="color: red;"><span class="glyphicon glyphicon-plus" aria-hidden="true" style="color: red;"></span> {{$locale->titulo}}</a>
                        @endif
                        <br>
                    @endforeach
                </div>
            </td>
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
            <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
        </div>
    </div>
</div>