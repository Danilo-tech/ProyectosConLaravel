<?php namespace Sivot\Http\Controllers\Editor\Altura;

use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Sivot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Sivot\Http\Librerias\CaracteresEspeciales;
use Sivot\Modelos\Editor\Altura\Actividades;
use Sivot\Modelos\Editor\Altura\Destino;
use Sivot\Modelos\Editor\Altura\Incluye;
use Sivot\Modelos\Editor\Altura\Levels;
use Sivot\Modelos\Editor\Altura\TiposTour;
use Sivot\Modelos\Editor\Altura\Tour;
use Sivot\Modelos\Editor\Altura\TourActividades;
use Sivot\Modelos\Editor\Altura\TourCupos;
use Sivot\Modelos\Editor\Altura\TourDestino;
use Sivot\Modelos\Editor\Altura\TourIncluye;
use Sivot\Modelos\Editor\Altura\TourLevels;
use Sivot\Modelos\Editor\Altura\TourTiposTour;
use Sivot\Modelos\Locales\Locale;

class TourController extends Controller {

    public function createincluye($idtour, $idincluye, Request $request)
    {
        if ($request->ajax()) {
            $incluye=Incluye::find($idincluye);
            $tour=Tour::find($idtour);
            $level_insert=TourIncluye::create(['tour_id'=>$idtour,'incluye_id'=>$idincluye,'cantidad'=>0]);
            $message='El incluye '.$incluye->nombre.' fue agregado al tour '.$tour->nombre;
            $titulo='INCLUIDOS ACTUALIZADOS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "identificador"=>$level_insert->id, "incluye"=>$incluye->nombre]);
        }
    }

    public function deleteincluye($idtour, $idincluye, Request $request)
    {
        if ($request->ajax()) {
            $incluye=Incluye::find($idincluye);
            $tour=Tour::find($idtour);
            TourIncluye::where('tour_id',$idtour)->where('incluye_id',$idincluye)->delete();
            $message='El incluye '.$incluye->nombre.' fue eliminado del tour '.$tour->nombre;
            $titulo='INCLUIDOS   ACTUALIZADOS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "incluye"=>$incluye->nombre]);
        }

        if ($request->ajax()) {


            $message='el incluido se elimino del tour';

            $titulo='Incluido actualizadas';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }
    }

    public function createactividad($idtour, $idactividades, Request $request)
    {
        if ($request->ajax()) {

            TourActividades::create(['tour_id'=>$idtour,'actividades_id'=>$idactividades]);
            $message='la actividad se adjunto al tour';

            $titulo='Actividades actualizadas';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }
    }

    public function deleteactividad($idtour, $idactividades, Request $request)
    {
        if ($request->ajax()) {

            TourActividades::where('tour_id',$idtour)->where('actividades_id',$idactividades)->delete();
            $message='la actividad se elimino del tour';

            $titulo='Actividades actualizadas';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }
    }

    public function createtipostour($idtour, $idtipostour, Request $request)
    {
        if ($request->ajax()) {

            TourTiposTour::create(['tour_id'=>$idtour,'tipos_tour_id'=>$idtipostour]);
            $message='el tipo tour se adjunto al tour';

            $titulo='Tipos actualizados';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }
    }

    public function deletetipostour($idtour, $idtipostour, Request $request)
    {
        if ($request->ajax()) {

            TourTiposTour::where('tour_id',$idtour)->where('tipos_tour_id',$idtipostour)->delete();
            $message='el tipo tour se elimino del tour';

            $titulo='TIPOS ACTUALIZADOS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }
    }

    public function createdestino($idtour, $iddestino, Request $request)
    {
        if ($request->ajax()) {

            TourDestino::create(['tour_id'=>$idtour,'destino_id'=>$iddestino]);
            $message='el destino tour se adjunto al tour';

            $titulo='Destinos actualizados';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }
    }

    public function deletedestino($idtour, $iddestino, Request $request)
    {
        if ($request->ajax()) {

            TourDestino::where('tour_id',$idtour)->where('destino_id',$iddestino)->delete();
            $message='el destino tour se elimino del tour';

            $titulo='DESTINOS ACTUALIZADOS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }
    }

    public function createlevel($idtour, $idlevel, Request $request)
    {
        if ($request->ajax()) {
            $level=Levels::find($idlevel);
            $tour=Tour::find($idtour);
            $level_insert=TourLevels::create(['tour_id'=>$idtour,'level_id'=>$idlevel,'precio'=>'0']);
            $message='El level '.$level->level.' fue agregado al tour '.$tour->nombre;
            $titulo='LEVELS ACTUALIZADOS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "identificador"=>$level_insert->id, "level"=>$level->level]);
        }

    }

    public function deletelevel($idtour, $idlevel, Request $request)
    {
        if ($request->ajax()) {
            $level=Levels::find($idlevel);
            $tour=Tour::find($idtour);
            TourLevels::where('tour_id','=',$idtour)->where('level_id','=',$idlevel)->delete();
            $message='El level '.$level->level.' fue eliminado del tour '.$tour->nombre;
            $titulo='LEVELS ACTUALIZADOS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "level"=>$level->level]);
        }

    }

    public function updateprecio(Request $request)
    {
        if ($request->ajax()) {
            $level = TourLevels::findOrFail($request->pk);
            $precio_data=array('precio'=>$request->value);
            $level->update($precio_data);
            $message='El precio del level de servicio fue actualizado correctamente';
            $titulo='PRECIO ACTUALIZADO';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }

    }

    public function updatecantidadincluye(Request $request)
    {
        if ($request->ajax()) {
            $incluye = TourIncluye::findOrFail($request->pk);
            $cantidad_data=array('cantidad'=>$request->value);
            $incluye->update($cantidad_data);
            $message='El cantidad fue actualizado correctamente';
            $titulo='CANTIDAD ACTUALIZADA';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);        }

    }

    public function updatecupos(Request $request)
    {
        if ($request->ajax()) {
            $cupo = TourCupos::findOrFail($request->pk);
            $cupo_data=array('cupos'=>$request->value);
            $cupo->update($cupo_data);
            $message='Los cupos fueron actualizado correctamente';
            $titulo='CUPOS ACTUALIZADOS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);        }

    }

    public function fecha($idtour, $fecha, Request $request)
    {
        if ($request->ajax()) {
            $existe=TourCupos::where('fecha',$fecha)->where('tour_id',$idtour)->get();
            if (count($existe)>0)
            {
                $existe[0]->delete();
                $message='La fecha de salida fue eliminada del sistema';
                $ope=0;
            }
            else
            {
                TourCupos::create(['fecha' => $fecha, 'tour_id' => $idtour, 'cupos' => 1]);
                $message='La fecha de salida fue agregada al sistema';
                $ope=1;
            }
            $titulo='FECHAS ACTUALIZADAS';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "operacion"=>$ope]);
        }

    }

    public function traductor($idtour, $language, $operacion)
    {
        $tour = Tour::findOrfail($idtour);
        $locale = Locale::findOrfail($language);
        $resumen_old = CaracteresEspeciales::htmlDiff($tour->translate($locale->language)->resumen_old, $tour->translate('en')->resumen);
        $nombre_old = CaracteresEspeciales::htmlDiff($tour->translate($locale->language)->nombre_old, $tour->translate('en')->nombre);
        $leyenda_list_old = CaracteresEspeciales::htmlDiff($tour->translate($locale->language)->leyenda_list_old, $tour->translate('en')->leyenda_list);
        $leyenda_detalle_old = CaracteresEspeciales::htmlDiff($tour->translate($locale->language)->leyenda_detalle_old, $tour->translate('en')->leyenda_detalle);
        $titulo_seo_old = CaracteresEspeciales::htmlDiff($tour->translate($locale->language)->titulo_seo_old, $tour->translate('en')->titulo_seo);
        $descripcion_seo_old = CaracteresEspeciales::htmlDiff($tour->translate($locale->language)->descripcion_seo_old, $tour->translate('en')->descripcion_seo);
        $url_amigable_old = CaracteresEspeciales::htmlDiff($tour->translate($locale->language)->url_amigable_old, $tour->translate('en')->url_amigable);
        return view('editor.altura.translate_tour', compact('tour','locale','operacion','resumen_old','nombre_old','leyenda_list_old','leyenda_detalle_old','titulo_seo_old','descripcion_seo_old','url_amigable_old'));
    }

    public function index()
    {
        $tour = Tour::OrderBy('id','Desc')->paginate();
        $locales = Locale::where('language','<>','en')->get();
        return view('editor.altura.index_tour', compact('tour','locales'));
    }

    public function create()
    {
        $tipostourlist= TiposTour::all();
        $destinolist= Destino::all();
        //$actividadlist= Actividades::all();
        $incluyelist= Incluye::all();
        $levels= Levels::all();
        return view('editor.altura.create_tour', compact('tipostourlist','destinolist','incluyelist','levels'));
    }

    public function store(Request $request)
    {
        $tour = Tour::create($request->all());
        $tipostour=Input::get('tipos');
        $destino=Input::get('destino');
        //$actividad=Input::get('actividades');
        $incluye=Input::get('incluye');
        $levels=Input::get('levels');
        $message='El tour '.$tour->nombre. ' fue registrado correctamente';
        Session::flash('message',$message);
        if (!empty($tipostour) and count($tipostour)>0)
        {
            foreach ($tipostour as $tipotour)
            {
                TourTiposTour::create(['tour_id'=>$tour->id,'tipos_tour_id'=>$tipotour]);
            }
        }
        if (!empty($destino) and count($destino)>0)
        {
            foreach ($destino as $destinos)
            {
                TourDestino::create(['tour_id'=>$tour->id,'destino_id'=>$destinos]);
            }
        }
        /*if (!empty($actividad) and count($actividad)>0)
        {
            foreach ($actividad as $actividades)
            {
                TourActividades::create(['tour_id'=>$tour->id,'actividades_id'=>$actividades]);
            }
        }*/
        if (!empty($incluye) and count($incluye)>0)
        {
            foreach ($incluye as $in)
            {
                TourIncluye::create(['cantidad' => Input::get('cantidad_'.$in),'tour_id'=>$tour->id,'incluye_id'=>$in]);
            }
        }
        if (!empty($levels) and count($levels)>0)
        {
            foreach ($levels as $level)
            {
                TourLevels::create(['precio' => Input::get('precio_'.$level),'tour_id'=>$tour->id,'level_id'=>$level]);
            }
        }
        if (Input::file('imagen_list')!=NULL){

            $rules = array('imagen_list'=>'image|max:400|mimes:jpeg,jpg,png');
            $validator = Validator::make(array('image'=> Input::file('imagen_list')), $rules);
            if($validator->passes())
            {
                $prefijo = rand(10000, 99999) . '_';
                $imagen = Image::make(Input::file('imagen_list'));
                $imagen->save('imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_list')->getClientOriginalName()));
                $ruta = 'imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_list')->getClientOriginalName());
                $image_data = array('imagen_list' => $ruta);
                $tour->update($image_data);
            }
            else{
                return redirect()->back()->withInput()->withErrors($validator->messages()->all());
            }
        }
        if (Input::file('imagen_detalle') != NULL) {

            $rules = array('imagen_detalle' => 'image|max:200|mimes:jpeg,jpg,png');
            $validator = Validator::make(array('image' => Input::file('imagen_detalle')), $rules);
            if ($validator->passes()) {
                $prefijo = rand(10000, 99999) . '_';
                $imagen = Image::make(Input::file('imagen_detalle'));
                $imagen->save('imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_detalle')->getClientOriginalName()));
                $ruta = 'imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_detalle')->getClientOriginalName());
                $imgdetalle_data = array('imagen_detalle' => $ruta);
                $tour->update($imgdetalle_data);
            } else {
                return redirect()->back()->withInput()->withErrors($validator->messages()->all());
            }
        }

        if (Input::file('imagen_header') != NULL) {

            $rules = array('imagen_header' => 'image|max:400|mimes:jpeg,jpg,png');
            $validator = Validator::make(array('image' => Input::file('imagen_header')), $rules);
            if ($validator->passes()) {
                $prefijo = rand(10000, 99999) . '_';
                $imagen = Image::make(Input::file('imagen_header'));
                $imagen->save('imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_header')->getClientOriginalName()));
                $ruta = 'imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_header')->getClientOriginalName());
                $imgdetalle_data = array('imagen_header' => $ruta);
                $tour->update($imgdetalle_data);
            } else {
                return redirect()->back()->withInput()->withErrors($validator->messages()->all());
            }
        }
        return redirect()->route('editor.altura.tour.index');
    }

    public function edit($id)
    {
        $tipostourlist= TiposTour::all();
        $destinolist= Destino::all();
        //$actividadlist= Actividades::all();
        $incluyelist= Incluye::all();
        $tour= Tour::findOrfail($id);
        $levels= Levels::all();
        $locales = Locale::where('language','<>','en')->get();
        $i=0;
        $lista_fechas=array();
        $dias=$tour->cupossalidas;
        foreach ($dias as $dia) {
            $lista_fechas[$i] = $dia->fecha;
            $i = $i + 1;
        }
        return view('editor.altura.edit_tour', compact('tour','tipostourlist','destinolist','incluyelist','levels','locales','lista_fechas'));
    }

    public function update(Request $request,$id)
    {
        if ($request->ajax()){
            \App::setLocale($request->language);
            $tour = Tour::findOrFail($id);
            $tour->update($request->all());
            $message='la información fue actualizada correctamente';
            $titulo='TRADUCCIÓN - '.strtoupper($request->language_titulo);
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "actualizado"=>$request->actualizado, "tour"=>$request->tour_id, "idioma"=>$request->language, "locale_id"=>$request->locale_id, "language_titulo"=>$request->language_titulo]);
        }
        else {
            $tour = Tour::findOrfail($id);
            $nombre_old = $tour->nombre;
            $resumen_old = $tour->resumen;
            $leyenda_list_old = $tour->leyenda_list;
            $leyenda_detalle_old = $tour->leyenda_detalle;
            $titulo_seo_old = $tour->titulo_seo;
            $descripcion_seo_old = $tour->descripcion_seo;
            $url_amigable_old = $tour->url_amigable;
            $tour->fill($request->all());
            $tour->save();
            if ($request->actualizado_general!=NULL)
            {
                $locales = Locale::where('language','<>','en')->get();
                $actualizado_data=array('actualizado'=>0);
                foreach($locales as $locale)
                {
                    \App::setLocale($locale->language);
                    if ($tour->actualizado==1)
                    {
                        $informacion_data=array('nombre_old'=>$nombre_old, 'resumen_old'=>$resumen_old, 'leyenda_list_old'=>$leyenda_list_old, 'leyenda_detalle_old'=>$leyenda_detalle_old, 'titulo_seo_old'=>$titulo_seo_old, 'descripcion_seo_old'=>$descripcion_seo_old, 'url_amigable_old'=>$url_amigable_old);
                        $tour->update($informacion_data);
                    }
                    $tour->update($actualizado_data);
                }
            }
            if (Input::file('imagen_list') != NULL) {
                $rules = array('imagen_list' => 'image|max:200|mimes:jpeg,jpg,png');
                $validator = Validator::make(array('image' => Input::file('imagen_list')), $rules);
                if ($validator->passes()) {
                    $prefijo = rand(10000, 99999) . '_';
                    $imagen = Image::make(Input::file('imagen_list'));
                    $imagen->save('imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_list')->getClientOriginalName()));
                    $ruta = 'imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_list')->getClientOriginalName());
                    $image_data = array('imagen_list' => $ruta);
                    $tour->update($image_data);
                } else {
                    return redirect()->back()->withInput()->withErrors($validator->messages()->all());
                }
            }
            if (Input::file('imagen_detalle') != NULL) {

                $rules = array('imagen_detalle' => 'image|max:200|mimes:jpeg,jpg,png');
                $validator = Validator::make(array('image' => Input::file('imagen_detalle')), $rules);
                if ($validator->passes()) {
                    $prefijo = rand(10000, 99999) . '_';
                    $imagen = Image::make(Input::file('imagen_detalle'));
                    $imagen->save('imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_detalle')->getClientOriginalName()));
                    $ruta = 'imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_detalle')->getClientOriginalName());
                    $imgdetalle_data = array('imagen_detalle' => $ruta);
                    $tour->update($imgdetalle_data);
                } else {
                    return redirect()->back()->withInput()->withErrors($validator->messages()->all());
                }
            }

            if (Input::file('imagen_header') != NULL) {

                $rules = array('imagen_header' => 'image|max:400|mimes:jpeg,jpg,png');
                $validator = Validator::make(array('image' => Input::file('imagen_header')), $rules);
                if ($validator->passes()) {
                    $prefijo = rand(10000, 99999) . '_';
                    $imagen = Image::make(Input::file('imagen_header'));
                    $imagen->save('imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_header')->getClientOriginalName()));
                    $ruta = 'imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen_header')->getClientOriginalName());
                    $imgdetalle_data = array('imagen_header' => $ruta);
                    $tour->update($imgdetalle_data);
                } else {
                    return redirect()->back()->withInput()->withErrors($validator->messages()->all());
                }
            }
            \App::setLocale('en');
            $message = $tour->nombre . ' fue actualizado correctamente';
            Session::flash('message', $message);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $tour= Tour::findOrfail($id);
        $message= 'El tour '.$tour->nombre. ' fue eliminado de la base de datos';
        $tour->delete();
        Session::flash('message',$message);
        return redirect()->route('editor.altura.tour.index');
    }
}