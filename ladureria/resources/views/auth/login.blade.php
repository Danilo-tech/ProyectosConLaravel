@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">
				<div class="panel-heading">
                    <blockquote>
                        <p>Login</p>
                        <footer style="color: white;">Ingrese su correo electrónico y contraseña</footer>
                    </blockquote>
                </div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> Por favor corrige los siguientes errores:<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					<form class="form-horizontal" role="form" method="POST" action="/auth/login">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
                            {!!Form::label('email' ,'Correo Electronico', ['class'=>'col-md-4 control-label'])!!}
							<div class="col-md-6">
                                {!!Form::text('email', null, ['class'=>'form-control', 'type'=>'email'])!!}
							</div>
						</div>

						<div class="form-group">
                            {!!Form::label('password' ,'Password', ['class'=>'col-md-4 control-label'])!!}
							<div class="col-md-6">
								<!--<input type="password" class="form-control" name="password">-->
                                {!!Form::password('password', ['class'=>'form-control'])!!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<div class="checkbox">
									<label>
                                        {!!Form::checkbox('remember')!!} Remember Me
									</label>
								</div>
							</div>
						</div>

						<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                    Login
                                </button>

                                <!--<a href="/password/email">Forgot Your Password?</a>-->
                            </div>
                        </div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
