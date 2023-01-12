<?php namespace Sivot\Http\Controllers\Admin;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Sivot\Http\Requests;
use Sivot\Http\Controllers\Controller;
use Sivot\User;
use Sivot\Http\Requests\Editor\CreateUserRequest;

class UsersController extends Controller {

    /*public function __construct()
    {
        //$this->middleware('auth');
    }*/

	public function index(Request $request)
	{

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CreateUserRequest $request)
	{
        $input = Input::all();
        if ($user = Sentinel::register($input))
        {
            $role_actual = Sentinel::findRoleById(3);
            $role_actual->users()->attach($user);
            $activation = Activation::create($user);
            $code = $activation->code;
            $sent = \Mail::send('emails.activar', compact('user', 'code'), function($message) use ($user)
            {
                $message->subject('Activa tu Cuenta');
                $message->from('mensajes@centroderecursosdrec.com', 'DREC - BUENAS PRACTICAS');
                //asunto
                $message->to($user->email, 'Usuario');
                $message->replyTo('noreply@centroderecursosdrec.com', 'noreply');
            });
            if ($sent === 0)
            {
                return redirect('admision?login=true')->withErrors('No se pudo enviar el correo de activacion');
            }

            $data['nombre']=$user->first_name.''.$user->last_name;
            $data['email']=$user->email;
            $sent = \Mail::send('emails.registrouser', ['data' => $data], function($message) use ($user)
            {
                $message->subject('Usuario Registrado');
                $message->from('mensajes@centroderecursosdrec.com', 'DREC - BUENAS PRACTICAS');
                //asunto
                $message->to('mensajes@centroderecursosdrec.com', 'DREC - BUENAS PRACTICAS');
                $message->replyTo('noreply@centroderecursosdrec.com', 'noreply');
            });

            $message='Su cuenta ha sido creada correctamente. Por seguridad le hemos enviado un correo con el cual podrá activar su cuenta. Por favor revise su bandeja de correo (incluso el no deseado). Muchas Gracias';
            Session::flash('message',$message);
            return redirect('admision?login=true');
        }

        return redirect('admision?login=true')
            ->withInput()
            ->withErrors('Error en el registro');

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

	}

}
