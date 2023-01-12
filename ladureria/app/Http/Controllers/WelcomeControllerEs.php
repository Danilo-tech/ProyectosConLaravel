<?php namespace Sivot\Http\Controllers;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Sivot\Http\Requests;
use Illuminate\Http\Request;
use Sivot\Modelos\Ikarri\Actividades;
use Sivot\Modelos\Ikarri\Blog;
use Sivot\Modelos\Ikarri\Hotel;
use Sivot\Modelos\Ikarri\Room;
use Sivot\Modelos\Ikarri\Tag;
use Sivot\Modelos\Ikarri\Incluye;
use Sivot\Modelos\Ikarri\CatBlog;
use Sivot\Modelos\Ikarri\GalHotel;
use Sivot\Modelos\Ikarri\GalRoom;
use Sivot\Modelos\Ikarri\Mactividades;
use Sivot\Modelos\Ikarri\Mblog;
use Sivot\Modelos\Ikarri\RoomIncluye;
class WelcomeControllerEs extends Controller {
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

	public function __construct()
	{
        \App::setLocale("es");
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
    public function index()
    {
        return view('inicio');
    }
    public function ourtrips()
    {
        $trip_show=Trip::all();
        $pais_show=Pais::all();
        $ciudad_show=Destino::all();
        $tipos_tour_show=TiposTour::all();
        return view('espage.ESourtrips',compact('trip_show','pais_show','tipos_tour_show','ciudad_show'));
    }
    public function destinations()
    {
        $destino_show=Destino::all();
        $m_destino_show=Mdestino::all();
        return view('espage.ESdestinations',compact('destino_show','m_destino_show'));
    }
    public function selectedtrip($nombre,$idtrip)
    {
        $trip_content=Trip::find($idtrip);
        $tour_trip=TourTrip::all();
        $tour=Tour::all();

        return view('espage.ESselectedtrip',compact('trip_content','tour_trip','tour'));
    }
    public function aboutdestination($nombre,$iddestino)
    {
        $destination_content=Destino::find($iddestino);
        return view('espage.ESaboutdestination',compact('destination_content'));
    }
    public function  makeityourown()
    {
        $destino_list=Destino::all();
        $pais=Pais::all();
        return view('espage.ESmakeityourown', compact('destino_list','pais'));
    }
    public function aboutus ()
    {
        $staff_show=Staff::all();
        return view('espage.ESaboutus', compact('staff_show'));
    }
    public function blog()
    {
        $blog_show=Blog::all();
        $catblog_show=CatBlog::all();
        $fondo='si';
        return view('espage.ESblog', compact('fondo','blog_show','catblog_show'));
    }
    public function aboutblog($nombre,$idblog)
    {
        $blog_content=Blog::find($idblog);
        return view('espage.ESaboutblog',compact('blog_content'));
    }
    public function orderform($nombre,$idtrip)
    {
        $pais=Pais::all();
        $trip_content=Trip::find($idtrip);
        return view('espage.ESorderform', compact('trip_content','pais'));
    }
    public function contacto_respuesta(Request $request)
    {
        if($request->ajax()) {
            $rules = array('email'=>'required|email', 'full_name'=>'required', 'phone'=>'required', 'message'=>'required');
            $validator = Validator::make(Input::all(), $rules); //recien validamos la informacion
            if ($validator->fails()){
                $titulo='Could not send mail';
                $mensaje = 'All field are required';
                return response()->json(["titulo"=>$titulo, "mensaje"=>$mensaje]);
            }
            $data = array();
            $data['full_name'] = $request->fullname;
            $data['email'] = $request->email;
            $data['phone'] = $request->phone;
            $data['message'] = $request->message;

            $mail = Mail::send('emails.contacto', ['data' => $data], function ($message) use ($request) {
                $message->subject('Contact Website');
                $message->from('info@schoolmasterapp.com', 'Altura Travel');
                //asunto
                $message->to('jkp_0583@hotmail.com', 'Altura Travel');
                $message->replyTo($request->email, $request->fullname);
            });

            if ($mail) {
                $titulo='Your message has been sent successfully';
                $mensaje = 'We will contact you as soon as possible. Thank you so much.
';
            } else {
                $titulo='Could not send mail';
                $mensaje = 'Server error, please try again later, sorry for the inconvenience.';
            }
            return response()->json(["titulo"=>$titulo, "mensaje"=>$mensaje]);
        }
    }

    public function respuesta_newsletter(Request $request)
    {
        if($request->ajax()) {
            $rules = array('email'=>'required|email', 'name'=>'required');
            $validator = Validator::make(Input::all(), $rules); //recien validamos la informacion
            if ($validator->fails()){
                $titulo='Subscription failed';
                $mensaje = 'All field are required';
                $estado=0;
                return response()->json(["titulo"=>$titulo, "mensaje"=>$mensaje, "estado"=>$estado]);
            }
            $news=Newsletter::where('email',$request-email)->get();
            if (count($news)>0){
                $titulo='Subscription failed';
                $mensaje = 'Your email is already registered';
                $estado=0;
                return response()->json(["titulo"=>$titulo, "mensaje"=>$mensaje, "estado"=>$estado]);
            }

            if (Newsletter::create(['email'=>$request->email,'nombres'=>$request->name])){
                $titulo='Successful subscription';
                $mensaje = 'We will contact you as soon as possible. Thank you so much.';
                $estado=1;
            }
             else {
                $titulo='Subscription failed';
                $mensaje = 'Server error, please try again later, sorry for the inconvenience.';
                $estado=0;
            }
            return response()->json(["titulo"=>$titulo, "mensaje"=>$mensaje, "estado"=>$estado]);
        }
    }
}
