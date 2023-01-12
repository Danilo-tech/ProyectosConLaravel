@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="page-header">
                    <h1 style="color: red;">Error <small style="color: red;">de acceso</small></h1>
                </div>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <blockquote>
                            <p>Acceso denegado!!!</p>
                        </blockquote>
                    </div>
                    <div class="panel-body">
                        <p>Esta intentando ingresar a una zona retringida, usted no tiene los permisos necesarios para poder proseguir</p>
                        <p>Si esta intentando forzar el acceso a esta página, será suspendido.</p>
                        <p><a href="javascript:window.history.back();"> Regresar a la pagina anterior</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection


