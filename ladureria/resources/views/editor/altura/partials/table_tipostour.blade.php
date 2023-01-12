<div class="table-responsive">
    <table class="table table-bordered">
    <tr>
        <th>Activitie</th>
        <th>Descripcion</th>
        <th>Opciones</th>
        <th style="width: 150px;">Traducciones</th>
    </tr>
    @foreach($tipostour as $tipostour)
        <?php $class='default';?>
        @foreach($locales as $locale)
            @if (isset($tipostour->translate($locale->language)->nombre))
                @if ($tipostour->translate($locale->language)->actualizado==1)
                    <?php $class.=' '.$locale->language.'-f';?>
                @endif
            @endif
        @endforeach
        <tr class="{{$class}}" data-id="{{$tipostour->id}}">
            <td>{{$tipostour->nombre}}</td>
            <td>{{$tipostour->descripcion}}</td>
            <td>
                <p><a href="{{route('editor.altura.tipostour.edit', $tipostour)}}" title="click to edit {{$tipostour->nombre}}"><span class="glyphicon glyphicon glyphicon-edit" aria-hidden="true"></span> Editar</a></p>
                <p>
                    {!! Form::open(['route'=> ['editor.altura.tipostour.destroy',$tipostour], 'method'=>'DELETE']) !!}
                    <button type="submit" onclick="return confirm('Seguro desea elminar el tipo de tour {{$tipostour->nombre}}')" class="btn btn-danger" title="eliminar tipo de tour {{$tipostour->nombre}}"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Eliminar</button>
                    {!! Form::close() !!}</p>
            </td>
            <td>
                <div class="well">
                    @foreach($locales as $locale)
                        @if (isset($tipostour->translate($locale->language)->nombre))
                            @if ($tipostour->translate($locale->language)->actualizado==1)
                                <a id="{{$tipostour->id}}-{{$locale->language}}" href="#!" title="La información esta traducida al {{$locale->titulo}} correctamente, click para ver" data-target="#myModal" class="traduccion" data-idt="{{$tipostour->id}}" data-idl="{{$locale->id}}" data-ido="ua" style="color: green;"><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color: green;"></span> {{$locale->titulo}}</a>
                            @else
                                <a id="{{$tipostour->id}}-{{$locale->language}}" href="#!" title="La traducción al {{$locale->titulo}} esta desactualizada, click para actualizar" data-target="#myModal" class="traduccion" data-idt="{{$tipostour->id}}" data-idl="{{$locale->id}}" data-ido="u" style="color: blue;"><span class="glyphicon glyphicon-refresh" aria-hidden="true" style="color: blue;"></span> {{$locale->titulo}}</a>
                            @endif
                        @else
                            <a id="{{$tipostour->id}}-{{$locale->language}}" href="#!" title="No existe traducción en {{$locale->titulo}}, click para traducir" data-target="#myModal" class="traduccion" data-idt="{{$tipostour->id}}" data-idl="{{$locale->id}}" data-ido="u" style="color: red;"><span class="glyphicon glyphicon-plus" aria-hidden="true" style="color: red;"></span> {{$locale->titulo}}</a>
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