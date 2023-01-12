<?php namespace Sivot\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Sivot\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Sivot\Modelos\Editor\Altura\Alianzas;
use Sivot\Modelos\Editor\Altura\Blog;
use Sivot\Modelos\Editor\Altura\Prodyserv;
use Sivot\Modelos\Editor\Altura\Contactano;
use Gmopx\LaravelOWM\LaravelOWM;
use Sivot\Modelos\Editor\Altura\Slider;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
        \App::setLocale("es");
	}
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */

	 // para cada ruta tenemos que hacer un clase
    public function index()
    {
        $menu=1;
        return view('inicio', compact('menu'));
    }
    public function sobre()
    {
        $menu=2;
        return view('sobre', compact('menu'));
    }
    public function laGuarderia()
    {
        $menu=3;
        return view('laguarderia', compact('menu'));
    }

    public function faq()
    {
        $menu=4;
        return view('faq', compact('menu'));
    }

    public function contacto()
    {
        $menu=5;
        return view('contacto', compact('menu'));
    }
    public function gateadores()
    {
        $menu=3;
        return view('gateadores', compact('menu'));
    }

    public function caminantes()
    {
        $menu=3;
        return view('caminantes', compact('menu'));
    }

    public function toddlers()
    {
        $menu=3;
        return view('toddlers', compact('menu'));
    }

    public function preEscolares()
    {
        $menu=3;
        return view('pre-escolares', compact('menu'));
    }


    public function contactoSend(Request $request)
    {
        $nombre=$request->name;
        $correo=$request->email;
        $mensaje=$request->message;
        $correoweb='josegeol@gmail.com';
        Mail::send('emails.contacto', ['nombre' => $nombre, 'correo' => $correo, 'mensaje' => $mensaje], function ($message) use ($correoweb)
        {
            $message->from('web@haciendasarapampa.com', 'Formulario de Contacto de tu Sitio Web: La Luderia!');
            $message->to($correoweb)->subject('Formulario de Contacto de tu Sitio Web: La Luderia!');
        });
        $notification = array(
            'message' => 'El mensaje a sido enviado exitosamente!',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

    public function buscador()
    {
        $buscar=Input::get('buscar');
        $search = '%'.$buscar.'%';
        $resultado = \DB::table('prodyserv_translations')
            ->where('titulo', 'LIKE', $search)
            ->orwhere('resumen', 'LIKE', $search)
            ->get();
        if (count($resultado)>0)
        {
            return view('search', compact('resultado','buscar'));
        }
        else
        {
            $notification = array(
                'message' => 'No coincide con ningún Tours.',
                'alert-type' => 'warning'
            );
            return back()->with($notification);
        }
    }
}
