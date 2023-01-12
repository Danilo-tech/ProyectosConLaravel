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
                    <li class="active">Registrar</li>
                </ol>
                @else
                <ol class="breadcrumb">
                    <li><a href="{{route('editor.altura.catblog.index',['model'=>$modelo])}}">Listar {{$datos["cabecera"]}}</a></li>
                    <li class="active">Registrar</li>
                </ol>
                @endif
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <blockquote>
                            @if (isset($padre))
                            <p>Registrar nuevo elemento a <b>"{{$padre_info->$r}}"</b></p>
                            @else
                            <p>Registrar nuevo elemento</p>
                            @endif
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
                        {!! Form::open(['route'=>'editor.altura.catblog.store', 'method'=>'POST', 'id'=>'formtable', 'files' => true]) !!}
                        @include('editor.altura.partials.fields_table_create')
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        @if (count($laterales)>0)
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    @foreach ($laterales as $lat)
                                        <div class="well">
                                            <h4>{{$lat->titulo}}</h4>
                                            <div class="form-group" data-toggle="popover" id="pa">
                                                @foreach ($lat->data as $elemento)
                                                    <?php $referencia=$lat->modeldata["nombre"];?>
                                                    <div class="checkbox checkbox-info">
                                                        <input id="{{$lat->funcion}}-{{$elemento->id}}" name="{{$lat->funcion}}[]" type="checkbox" value="{{$elemento->id}}">
                                                        <label for="{{$lat->funcion}}-{{$elemento->id}}" style="font-size: 12px;"> {{$elemento->$referencia}} </label>
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
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var indice_imagen=1;
        $(document).ready(function() {

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
                    browseLabel: "Selecionar imagen",
                    browseClass: "btn btn-success"
                });
                indice_imagen=indice_imagen+1;
                @endif
            @endforeach

            $(".updown").TouchSpin({
                verticalbuttons: true,
                initval: 1,
                min:1
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
            });
        });
    </script>
@endsection