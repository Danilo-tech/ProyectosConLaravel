<?php namespace Sivot\Http\Controllers\Editor\Altura;

use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Sivot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Sivot\Http\Librerias\CaracteresEspeciales;
use Sivot\Modelos\Editor\Altura\Agenda;
use Sivot\Modelos\Editor\Altura\Destino;
use Sivot\Modelos\Editor\Altura\Levels;
use Sivot\Modelos\Editor\Altura\Tour;
use Sivot\Modelos\Editor\Altura\TourTrip;
use Sivot\Modelos\Editor\Altura\Trip;
use Sivot\Modelos\Editor\Altura\TripLevels;
use Sivot\Modelos\Locales\Locale;

class TripController extends Controller {

    public function traductor($idtrip, $language, $operacion)
    {
        $trip = Trip::findOrfail($idtrip);
        $locale = Locale::findOrfail($language);
        $descripcion_old = CaracteresEspeciales::htmlDiff($trip->translate($locale->language)->descripcion_old, $trip->translate('en')->descripcion);
        $nombre_old = CaracteresEspeciales::htmlDiff($trip->translate($locale->language)->nombre_old, $trip->translate('en')->nombre);
        $notas_old = CaracteresEspeciales::htmlDiff($trip->translate($locale->language)->notas_old, $trip->translate('en')->notas);
        $leyenda_list_old = CaracteresEspeciales::htmlDiff($trip->translate($locale->language)->leyenda_list_old, $trip->translate('en')->leyenda_list);
        $leyenda_detalle_old = CaracteresEspeciales::htmlDiff($trip->translate($locale->language)->leyenda_detalle_old, $trip->translate('en')->leyenda_detalle);
        $titulo_seo_old = CaracteresEspeciales::htmlDiff($trip->translate($locale->language)->titulo_seo_old, $trip->translate('en')->titulo_seo);
        $descripcion_seo_old = CaracteresEspeciales::htmlDiff($trip->translate($locale->language)->descripcion_seo_old, $trip->translate('en')->descripcion_seo);
        $url_amigable_old = CaracteresEspeciales::htmlDiff($trip->translate($locale->language)->url_amigable_old, $trip->translate('en')->url_amigable);
        return view('editor.altura.translate_trip', compact('trip','locale','operacion','descripcion_old','nombre_old','notas_old','leyenda_list_old','leyenda_detalle_old','titulo_seo_old','descripcion_seo_old','url_amigable_old'));
    }

    public function fecha($idtrip, $fecha, Request $request)
    {
        if ($request->ajax()) {
            $existe=Agenda::where('fecha',$fecha)->where('trip_id',$idtrip)->get();
            if (count($existe)>0)
            {
                $existe[0]->delete();
                $message='La fecha de salida fue eliminada del sistema';
                $ope=0;
            }
            else
            {
                Agenda::create(['fecha' => $fecha, 'trip_id' => $idtrip]);
                $message='La fecha de salida fue agregada al sistema';
                $ope=1;
            }
            $titulo='FECHAS ACTUALIZADAS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "operacion"=>$ope]);
        }

    }

    public function createtourtrip($idtrip, $idtour, Request $request)
    {
        if ($request->ajax()) {

            $trip_order=TourTrip::where('trip_id',$idtrip)->orderBy('orden','DESC')->take(1)->get();
            if (count($trip_order)>0)
            $nuevo_order=$trip_order[0]->orden+1;
            else
                $nuevo_order=1;
            TourTrip::create(['tour_id'=>$idtour,'trip_id'=>$idtrip, 'orden'=>$nuevo_order]);
            //actualizamos duracion
            $tour=Tour::findOrFail($idtour);
            $duracion_tour=$tour->duracion;
            $trip=Trip::findOrFail($idtrip);
            $duracion_trip=$trip->duracion;
            $duracion_data=array('duracion'=>$duracion_trip+$duracion_tour);
            $trip->update($duracion_data);
            $message='el tour se adjunto al trip';

            $titulo='TRIP ACTUALIZADO';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }
    }

    public function deletetourtrip($idtrip, $idtour, Request $request)
    {
        if ($request->ajax()) {
            $tour=Tour::findOrFail($idtour);
            $duracion_tour=$tour->duracion;
            $trip=Trip::findOrFail($idtrip);
            $duracion_trip=$trip->duracion;
            $duracion_data=array('duracion'=>$duracion_trip-$duracion_tour);
            $trip->update($duracion_data);

            TourTrip::where('tour_id',$idtour)->where('trip_id',$idtrip)->delete();
            $message='el tour se removio del trip';


            $titulo='TRIP ACTUALIZADO';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }
    }

    public function updateprecio(Request $request)
    {
        if ($request->ajax()) {
            $level = TripLevels::findOrFail($request->pk);
            $precio_data=array('precio'=>$request->value);
            $level->update($precio_data);
            $message='El precio del level de servicio fue actualizado correctamente';
            $titulo='PRECIO ACTUALIZADO';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }

    }

    public function updatecupos(Request $request)
    {
        if ($request->ajax()) {
            $cupo = Agenda::findOrFail($request->pk);
            $cupo_data=array('cupos'=>$request->value);
            $cupo->update($cupo_data);
            $message='Los cupos fueron actualizado correctamente';
            $titulo='CUPOS ACTUALIZADOS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);        }

    }

    public function createlevel($idtrip, $idlevel, Request $request)
    {
        if ($request->ajax()) {
            $level=Levels::find($idlevel);
            $trip=Trip::find($idtrip);
            $level_insert=TripLevels::create(['trip_id'=>$idtrip,'level_id'=>$idlevel,'precio'=>'0']);
            $message='El level '.$level->level.' fue agregado al tour '.$trip->nombre;
            $titulo='LEVELS ACTUALIZADOS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "identificador"=>$level_insert->id, "level"=>$level->level]);
        }

    }

    public function deletelevel($idtrip, $idlevel, Request $request)
    {
        if ($request->ajax()) {
            $level=Levels::find($idlevel);
            $trip=Trip::find($idtrip);
            TripLevels::where('trip_id','=',$idtrip)->where('level_id','=',$idlevel)->delete();
            $message='El level '.$level->level.' fue eliminado del tour '.$trip->nombre;
            $titulo='LEVELS ACTUALIZADOS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "level"=>$level->level]);
        }

    }

    public function index(Request $request)
    {
        $trip = Trip::OrderBy('id','Desc')->paginate();
        $locales = Locale::where('language','<>','en')->get();
        return view('editor.altura.index_trip', compact('trip','locales','tripsearch'));
    }

    public function create()
    {
        $destinos=Destino::all();
        $levels=Levels::all();
        $trips=Trip::all();
        $agrupados=array();
        $i=0;
        foreach ($trips as $trip){
            if (!in_array($trip->agrupar, $agrupados)){
                $agrupados[$i]= $trip->agrupar;
                $i=$i+1;
            }
        }
        return view('editor.altura.create_trip',compact('destinos','levels','agrupados'));
    }

    public function store(Request $request)
    {
        $trip = Trip::create($request->all());
        $message='El trip '.$trip->nombre. ' fue registrado correctamente';
        Session::flash('message',$message);
        $tours=explode(',',$request->orden);
        $levels=Input::get('levels');
        $orden=1;
        foreach ($tours as $tour){
            if ($tour!=''){
                TourTrip::create(['tour_id'=>$tour,'trip_id'=>$trip->id, 'orden'=>$orden]);
                $orden++;
            }
        }

        if (!empty($levels) and count($levels)>0)
        {
            foreach ($levels as $level)
            {
                TripLevels::create(['precio' => Input::get('precio_'.$level),'trip_id'=>$trip->id,'level_id'=>$level]);
            }
        }

        if (Input::file('imagen_list')!=NULL){

            $rules = array('imagen_list'=>'image|max:400|mimes:jpeg,jpg,png');
            $validator = Validator::make(array('image'=> Input::file('imagen_list')), $rules);
            if($validator->passes())
            {
                $prefijo = rand(10000, 99999) . '_';
                $imagen = Image::make(Input::file('imagen_list'));
                $imagen->save('imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_list')->getClientOriginalName()));
                $ruta = 'imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_list')->getClientOriginalName());
                $imglista_data = array('imagen_list' => $ruta);
                $trip->update($imglista_data);
            }
            else{
                return redirect()->back()->withInput()->withErrors($validator->messages()->all());
            }
        }
        if (Input::file('imagen_detalle')!=NULL){

            $rules = array('imagen_detalle'=>'image|max:400|mimes:jpeg,jpg,png');
            $validator = Validator::make(array('image'=> Input::file('imagen_detalle')), $rules);
            if($validator->passes())
            {
                $prefijo = rand(10000, 99999) . '_';
                $imagen = Image::make(Input::file('imagen_detalle'));
                $imagen->save('imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_detalle')->getClientOriginalName()));
                $ruta = 'imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_detalle')->getClientOriginalName());
                $imgdetalle_data = array('imagen_detalle' => $ruta);
                $trip->update($imgdetalle_data);
            }
            else{
                return redirect()->back()->withInput()->withErrors($validator->messages()->all());
            }
        }

        if (Input::file('imagen_header')!=NULL){

            $rules = array('imagen_header'=>'image|max:400|mimes:jpeg,jpg,png');
            $validator = Validator::make(array('image'=> Input::file('imagen_header')), $rules);
            if($validator->passes())
            {
                $prefijo = rand(10000, 99999) . '_';
                $imagen = Image::make(Input::file('imagen_header'));
                $imagen->save('imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_header')->getClientOriginalName()));
                $ruta = 'imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_header')->getClientOriginalName());
                $imgdetalle_data = array('imagen_header' => $ruta);
                $trip->update($imgdetalle_data);
            }
            else{
                return redirect()->back()->withInput()->withErrors($validator->messages()->all());
            }
        }


        return redirect()->route('editor.altura.trip.index');
    }

    public function edit($id)
    {
        $trip= Trip::findOrfail($id);        
        $tourlist= Tour::all();
        $destinos= Destino::all();
        $i=0;
        $lista_fechas=array();
        $dias=$trip->dias;
        foreach ($dias as $dia) {
            $lista_fechas[$i] = $dia->fecha;
            $i = $i + 1;
        }
        $trips=Trip::all();
        $agrupados=array();
        $i=0;
        foreach ($trips as $tripok){
            if (!in_array($tripok->agrupar, $agrupados)){
                $agrupados[$i]= $tripok->agrupar;
                $i=$i+1;
            }
        }
        $levels=Levels::all();
        return view('editor.altura.edit_trip', compact('trip','tourlist','destinos','lista_fechas','agrupados','levels'));
    }


    public function update(Request $request,$id)
    {
        if ($request->ajax()){
            \App::setLocale($request->language);
            $trip = Trip::findOrFail($id);
            $trip->update($request->all());
            $message='la información fue actualizada correctamente';
            $titulo='TRADUCCIÓN - '.strtoupper($request->language_titulo);
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "actualizado"=>$request->actualizado, "trip"=>$request->trip_id, "idioma"=>$request->language, "locale_id"=>$request->locale_id, "language_titulo"=>$request->language_titulo]);
        }
        else {
            $trip = Trip::findOrfail($id);
            $nombre_old = $trip->nombre;
            $resumen_old = $trip->resumen;
            $notas_old = $trip->notas;
            $leyenda_list_old = $trip->leyenda_list;
            $leyenda_detalle_old = $trip->leyenda_detalle;
            $titulo_seo_old = $trip->titulo_seo;
            $descripcion_seo_old = $trip->descripcion_seo;
            $url_amigable_old = $trip->url_amigable;
            $trip->fill($request->all());
            $trip->save();

            if ($request->actualizado_general!=NULL)
            {
                $locales = Locale::where('language','<>','en')->get();
                $actualizado_data=array('actualizado'=>0);
                foreach($locales as $locale)
                {
                    \App::setLocale($locale->language);
                    if ($trip->actualizado==1)
                    {
                        $informacion_data=array('nombre_old'=>$nombre_old, 'resumen_old'=>$resumen_old, 'notas_old'=>$notas_old, 'leyenda_list_old'=>$leyenda_list_old, 'leyenda_detalle_old'=>$leyenda_detalle_old, 'titulo_seo_old'=>$titulo_seo_old, 'descripcion_seo_old'=>$descripcion_seo_old, 'url_amigable_old'=>$url_amigable_old);
                        $trip->update($informacion_data);
                    }
                    $trip->update($actualizado_data);
                }
            }
            if (Input::file('imagen_lista') != NULL) {
                $rules = array('imagen_lista' => 'image|max:400|mimes:jpeg,jpg,png');
                $validator = Validator::make(array('imagen_lista' => Input::file('imagen_lista')), $rules);
                if ($validator->passes()) {
                    $prefijo = rand(10000, 99999) . '_';
                    $imagen = Image::make(Input::file('imagen_lista'));
                    $imagen->save('imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_lista')->getClientOriginalName()));
                    $ruta = 'imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_lista')->getClientOriginalName());
                    $imgdetalle_data = array('imagen_lista' => $ruta);
                    $trip->update($imgdetalle_data);
                } else {
                    return redirect()->back()->withInput()->withErrors($validator->messages()->all());
                }
            }
            if (Input::file('imagen_detalle') != NULL) {
                $rules = array('imagen_detalle' => 'image|max:400|mimes:jpeg,jpg,png');
                $validator = Validator::make(array('imagen_detalle' => Input::file('imagen_detalle')), $rules);
                if ($validator->passes()) {
                    $prefijo = rand(10000, 99999) . '_';
                    $imagen = Image::make(Input::file('imagen_detalle'));
                    $imagen->save('imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_detalle')->getClientOriginalName()));
                    $ruta = 'imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_detalle')->getClientOriginalName());
                    $imgdetalle_data = array('imagen_detalle' => $ruta);
                    $trip->update($imgdetalle_data);
                } else {
                    return redirect()->back()->withInput()->withErrors($validator->messages()->all());
                }
            }
            if (Input::file('imagen_header')!=NULL){

                $rules = array('imagen_header'=>'image|max:400|mimes:jpeg,jpg,png');
                $validator = Validator::make(array('image'=> Input::file('imagen_header')), $rules);
                if($validator->passes())
                {
                    $prefijo = rand(10000, 99999) . '_';
                    $imagen = Image::make(Input::file('imagen_header'));
                    $imagen->save('imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_header')->getClientOriginalName()));
                    $ruta = 'imagenes/trip/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_header')->getClientOriginalName());
                    $imgdetalle_data = array('imagen_header' => $ruta);
                    $trip->update($imgdetalle_data);
                }
                else{
                    return redirect()->back()->withInput()->withErrors($validator->messages()->all());
                }
            }
            \App::setLocale('en');
            $message = $trip->nombre . ' has been update';
            Session::flash('message', $message);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $trip= Trip::findOrfail($id);
        $message= 'the trip '.$trip->nombre. ' has been removed from database';
        $trip->delete();
        Session::flash('message',$message);
        return redirect()->route('editor.altura.trip.index');
    }
}