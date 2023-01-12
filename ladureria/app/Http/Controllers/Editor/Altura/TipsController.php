<?php namespace Sivot\Http\Controllers\Editor\Altura;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Sivot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Sivot\Http\Librerias\CaracteresEspeciales;
use Sivot\Modelos\Editor\Altura\Area;
use Sivot\Modelos\Editor\Altura\Destino;
use Sivot\Modelos\Editor\Altura\DestinoTips;
use Sivot\Modelos\Editor\Altura\Pais;
use Sivot\Modelos\Locales\Locale;

class TipsController extends Controller {

    public function traductor($idtip, $language, $operacion)
    {
        $tip = DestinoTips::findOrfail($idtip);
        $locale = Locale::findOrfail($language);
        $descripcion_old = CaracteresEspeciales::htmlDiff($tip->translate($locale->language)->descripcion_old, $tip->translate('en')->descripcion);
        $titulo_old = CaracteresEspeciales::htmlDiff($tip->translate($locale->language)->titulo_old, $tip->translate('en')->titulo);
        $leyenda_old = CaracteresEspeciales::htmlDiff($tip->translate($locale->language)->leyenda_old, $tip->translate('en')->leyenda);
        return view('editor.altura.translate_tip', compact('tip','locale','operacion','descripcion_old','titulo_old','leyenda_old'));
    }

    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $tip = DestinoTips::create($request->all());
        if (Input::file('imagentip')!=NULL){

            $rules = array('imagentip'=>'imagentip|max:150|mimes:jpeg,jpg,png');
            $validator = Validator::make(array('image'=> Input::file('imagentip')), $rules);
            if($validator->passes())
            {
                $prefijo = rand(10000, 99999) . '_';
                $imagen = Image::make(Input::file('imagentip'));
                $imagen->save('imagenes/tips/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagentip')->getClientOriginalName()));
                $ruta = 'imagenes/tips/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagentip')->getClientOriginalName());
                $imagen_data = array('imagen' => $ruta);
                $tip->update($imagen_data);
            }
            else{
                return redirect()->back()->withInput()->withErrors($validator->messages()->all());
            }
        }

        $message='El tip '.$tip->titulo. ' fue registrado correctamente';
        Session::flash('message',$message);
        return redirect()->back();
    }

    public function edit($id)
    {
        $tip= DestinoTips::findOrfail($id);
        $destino=Destino::find($tip->destino_id);
        return view('editor.altura.edit_tip', compact('tip','destino'));
    }

    public function update(Request $request,$id)
    {
        if ($request->ajax()){
            \App::setLocale($request->language);
            $tip = DestinoTips::findOrFail($id);
            $tip->update($request->all());
            $message='la información fue actualizada correctamente';
            $titulo='TRADUCCIÓN - '.strtoupper($request->language_titulo);
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "actualizado"=>$request->actualizado, "tip"=>$request->tip_id, "idioma"=>$request->language, "locale_id"=>$request->locale_id, "language_titulo"=>$request->language_titulo]);
        }
        else {
            $tip = DestinoTips::findOrfail($id);
            $titulo_old = $tip->titulo;
            $descripcion_old = $tip->descripcion;
            $leyenda_old = $tip->leyenda;
            $tip->fill($request->all());
            $tip->save();
            if ($request->actualizado_general!=NULL)
            {
                $locales = Locale::where('language','<>','en')->get();
                $actualizado_data=array('actualizado'=>0);
                foreach($locales as $locale)
                {
                    \App::setLocale($locale->language);
                    if ($tip->actualizado==1)
                    {
                        $informacion_data=array('titulo_old'=>$titulo_old, 'descripcion_old'=>$descripcion_old, 'leyenda_old'=>$leyenda_old);
                        $tip->update($informacion_data);
                    }
                    $tip->update($actualizado_data);
                }
            }
            if (Input::file('imagen')!=NULL){
                $rules = array('imagen'=>'imagen|max:150|mimes:jpeg,jpg,png');
                $validator = Validator::make(array('image'=> Input::file('imagen')), $rules);
                if($validator->passes())
                {
                    $prefijo = rand(10000, 99999) . '_';
                    $imagen = Image::make(Input::file('imagen'));
                    $imagen->save('imagenes/tips/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen')->getClientOriginalName()));
                    $ruta = 'imagenes/tips/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file('imagen')->getClientOriginalName());
                    $imagen_data = array('imagen' => $ruta);
                    $tip->update($imagen_data);
                }
                else{
                    return redirect()->back()->withInput()->withErrors($validator->messages()->all());
                }
            }

            \App::setLocale('en');
            $message = $tip->titulo . ' fue actualizado correctamente';
            Session::flash('message', $message);
            //return redirect()->back();
            return redirect()->route('editor.altura.destino.edit',$tip->destino_id);
        }
    }

    public function destroy($id)
    {
        $tip= DestinoTips::findOrfail($id);
        $message= 'El tip '.$tip->titulo. ' fue eliminado de la base de datos';
        $tip->delete();
        Session::flash('message',$message);
        return redirect()->back();
    }
}