<?php namespace Sivot\Http\Controllers\Editor\Altura;

use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Sivot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Sivot\Modelos\Editor\Altura\TiposTour;
use Sivot\Http\Librerias\CaracteresEspeciales;
use Sivot\Modelos\Locales\Locale;

class TiposTourController extends Controller {


    public function traductor($idtipostour, $language, $operacion)
    {
        $tipostour = TiposTour::findOrfail($idtipostour);
        $locale = Locale::findOrfail($language);
        $descripcion_old = CaracteresEspeciales::htmlDiff($tipostour->translate($locale->language)->descripcion_old, $tipostour->translate('en')->descripcion);
        $nombre_old = CaracteresEspeciales::htmlDiff($tipostour->translate($locale->language)->nombre_old, $tipostour->translate('en')->nombre);
        return view('editor.altura.translate_tipostour', compact('tipostour','locale','operacion','descripcion_old','nombre_old'));
    }

	public function index()
	{
        $tipostour = TiposTour::OrderBy('id','Desc')->paginate();
        $locales = Locale::where('language','<>','en')->get();
        return view('editor.altura.index_tipostour', compact('tipostour','locales'));
	}

	public function create()
	{
        return view('editor.altura.create_tipostour');
	}

	public function store(Request $request)
	{
        $tipostour = TiposTour::create($request->all());
        $message='El activitie '.$tipostour->nombre. ' fue registrado correctamente';
        Session::flash('message',$message);
        if (Input::file('imagen')!=NULL){

            $rules = array('imagen'=>'imagen|max:400|mimes:jpeg,jpg,png');
            $validator = Validator::make(array('image'=> Input::file('imagen')), $rules);
            if($validator->passes())
            {
                $prefijo = rand(10000, 99999) . '_';
                $imagen = Image::make(Input::file('imagen'));
                $imagen->save('imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen')->getClientOriginalName()));
                $ruta = 'imagenes/tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen')->getClientOriginalName());
                $image_data = array('imagen' => $ruta);
                $tipostour->update($image_data);
            }
            else{
                return redirect()->back()->withInput()->withErrors($validator->messages()->all());
            }
        }
        return redirect()->route('editor.altura.tipostour.index');
	}


	public function edit($id)
	{
        $tipostour= TiposTour::findOrfail($id);
        return view('editor.altura.edit_tipostour', compact('tipostour'));
	}

	public function update(Request $request,$id)
	{
        if ($request->ajax()){
            \App::setLocale($request->language);
            $tipostour = TiposTour::findOrFail($id);
            $tipostour->update($request->all());
            $message='la información fue actualizada correctamente';
            $titulo='TRADUCCIÓN - '.strtoupper($request->language_titulo);
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "actualizado"=>$request->actualizado, "tipostour"=>$request->tipostour_id, "idioma"=>$request->language, "locale_id"=>$request->locale_id, "language_titulo"=>$request->language_titulo]);
        }
        else {
            $tipostour = TiposTour::findOrfail($id);
            $nombre_old = $tipostour->nombre;
            $descripcion_old = $tipostour->descripcion;
            $tipostour->fill($request->all());
            $tipostour->save();
            if ($request->actualizado_general!=NULL)
            {
                $locales = Locale::where('language','<>','en')->get();
                $actualizado_data=array('actualizado'=>0);
                foreach($locales as $locale)
                {
                    \App::setLocale($locale->language);
                    if ($tipostour->actualizado==1)
                    {
                        $informacion_data=array('nombre_old'=>$nombre_old, 'descripcion_old'=>$descripcion_old);
                        $tipostour->update($informacion_data);
                    }
                    $tipostour->update($actualizado_data);
                }
            }
            if (Input::file('imagen') != NULL) {

                $rules = array('imagen' => 'image|max:100|mimes:jpeg,jpg,png');
                $validator = Validator::make(array('imagen' => Input::file('imagen')), $rules);
                if ($validator->passes()) {
                    $prefijo = rand(10000, 99999) . '_';
                    $imagen = Image::make(Input::file('imagen'));
                    $imagen->save('imagenes/tipos_tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen')->getClientOriginalName()));
                    $ruta = 'imagenes/tipos_tour/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen')->getClientOriginalName());
                    $imagen_data = array('imagen' => $ruta);
                    $tipostour->update($imagen_data);
                } else {
                    return redirect()->back()->withInput()->withErrors($validator->messages()->all());
                }
            }

            \App::setLocale('en');
            $message = $tipostour->nombre . ' fue actualizado correctamente';
            Session::flash('message', $message);
            return redirect()->back();
        }
	}

	public function destroy($id)
	{
        $tipostour= TiposTour::findOrfail($id);
        $message= 'El activitie '.$tipostour->nombre. ' fue eliminado de la base de datos';
        $tipostour->delete();
        Session::flash('message',$message);
        return redirect()->route('editor.altura.tipostour.index');
	}

}
