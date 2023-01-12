<?php namespace Sivot\Http\Middleware;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Routing\Route;

class Permisos {

	/**
	 * The Guard implementation.
	 *
	 * @var Guard
	 */
	protected $auth;
    protected $route;

	/**
	 * Create a new filter instance.
	 *
	 * @param  Guard  $auth
	 * @return void
	 */
	public function __construct(Guard $auth, Route $route)
	{
		$this->auth = $auth;
        $this->route=$route;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $uri = $this->route->getUri();
        if (strpos($uri, 'home')!== false){
            $ruta=$uri;
        }
        else{
            $action = $this->route->getAction();
            $ruta=$action['as'];
        }
        //dd($action);
        //dd($action['as']);
        //dd(Sentinel::hasAccess("editor.usuarios.user.index"));
        //dd($ruta);
        if (!Sentinel::hasAccess($ruta))
        {
			if ($request->ajax())
			{
				//return response('Unauthorized.', 401);
                return view('errors.permisosajax');
			}
			else
			{
				//return redirect()->guest('auth/login');
                return view('errors.permisos');
			}
		}

		return $next($request);
	}

}
