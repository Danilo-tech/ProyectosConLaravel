@extends('app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="page-header">
                    <h1>{{$datos["cabecera"]}}</h1>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <blockquote>
                            <p>Lista de registros</p>
                            <footer style="color: white;">Hay <span class="badge">{{count($registros)}}</span> elementos registrados</footer>
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
                        @if ($datos["registrar"])<p><a class="btn btn-success" href="{{route('editor.altura.catblog.create',['model'=>$modelo])}}" role="button">Registrar Elemento</a></p>@endif
                        @if ($datos["traducir"])
                        <div class="well">
                            <div class="radio radio-info ">
                                <input id="inlineRadio1" name="opciones" type="radio" value="0" onclick="actualizar_vista(this.value)" checked>
                                <label for="inlineRadio1" style="font-size: 12px;"> Mostrar todos </label>
                            </div>
                            <?php $i=2;?>
                            @foreach($locales as $locale)
                                <div class="radio radio-info ">
                                    <input id="inlineRadio{{$i}}" name="opciones" type="radio" value="{{$locale->language}}" onclick="actualizar_vista(this.value)">
                                    <label for="inlineRadio{{$i}}" style="font-size: 12px;"> Faltan traducir al {{$locale->titulo}} </label>
                                </div>
                                <?php $i=$i+1;?>
                            @endforeach
                        </div>
                        @endif

                        @include('editor.altura.partials.table')

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function actualizar_vista(valor)
        {
            $('.default').fadeIn();
            if (valor!=0)
                $('.'+valor+'-f').fadeOut();
        }

        $(document).ready(function(){
            $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner =
                    '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
                    '<div class="progress progress-striped active">' +
                    '<div class="progress-bar" style="width: 100%;">Cargando</div>' +
                    '</div>' +
                    '</div>';

            $.fn.modalmanager.defaults.resize = true;
            var $modal = $('#myModal');
            $('.traduccion').on('click', function(){
                // create the backdrop and wait for next modal to be triggered
                $('body').modalmanager('loading');
                var idelemento = $(this).data('idc');
                var idlanguage = $(this).data('idl');
                var operacion = $(this).data('ido');
                var url = '{{ route("tabla-traductor", [':idc',':idl',':ido',':idm']) }}';
                url = url.replace(':idc', idelemento);
                url = url.replace(':idl', idlanguage);
                url = url.replace(':ido', operacion);
                url = url.replace(':idm', '{{$modelo}}');
                setTimeout(function(){
                    $modal.load(url, '', function(){
                        $modal.modal('toggle');
                    });
                }, 1000);
            });

            $('.popi').on('click', function(e) {
                e.preventDefault();
                $('body').modalmanager('loading');
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });
        });
    </script>
@endsection
