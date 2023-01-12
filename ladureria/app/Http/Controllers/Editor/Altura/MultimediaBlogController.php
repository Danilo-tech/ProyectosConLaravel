<?php namespace Sivot\Http\Controllers\Editor\Altura;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Sivot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Sivot\Modelos\Editor\Altura\Destino;

use Sivot\Http\Librerias\CaracteresEspeciales;
use Sivot\Modelos\Editor\Altura\Mblog;
use Sivot\Modelos\Editor\Altura\Mdestino;
use Sivot\Modelos\Locales\Locale;

class MultimediaBlogController extends Controller {


	public function index()
	{

	}

	public function create()
	{

	}

	public function store(Request $request)
	{
        $modelo=$request->modelo;
        $modelo_object=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo);
        $principal=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->principal;
        $message='las imagenes fueron registradas correctamente';
        Session::flash('message',$message);
        $files = Input::file('imagen');
        $file_count = count($files);
        $uploadcount = 0;
        if ($file_count>0) {
            foreach ($files as $file) {
                $prefijo = rand(10000, 99999) . '_';
                $img = Image::make($file);
                $partes = explode('.', $file->getClientOriginalName());
                $leyenda = $partes[0];
                $img->save('imagenes/multimedia_blog/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen($file->getClientOriginalName()));
                $ruta = 'imagenes/multimedia_blog/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen($file->getClientOriginalName());
                $modelo_object::create([$principal => $request->principal_id, 'imagen' => $ruta, 'leyenda' => $leyenda, 'urlvideo' => '']);
                $uploadcount++;
            }
            return redirect()->back();
        }
        else{
            if ($request->urlvideo!=NULL) {
                $modelo_object::create([$principal => $request->principal_id, 'imagen' => '', 'leyenda' => 'multimedia', 'urlvideo' => $request->urlvideo]);
                $message = ' El video se cargo exitosamente';
                Session::flash('message', $message);
                return redirect()->back();
            }else{
                if ($request->urlenlace!=NULL) {
                    $modelo_object::create([$principal => $request->principal_id, 'imagen' => '', 'leyenda' =>"titulo enlace", 'urlenlace' => $request->urlenlace]);
                    $message = ' El enlace se cargo exitosamente';
                    Session::flash('message', $message);
                    return redirect()->back();
                }
            }
        }
	}

	public function edit($id)
	{

	}

	public function update(Request $request,$id)
	{
        if ($request->ajax())
        {
            $modelo=$request->model;
            $modelo_object = \App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->findOrfail($id);
            if ($request->pk=='es')
            {
                $leyenda_ant=$modelo_object->leyenda;
                $leyenda_nuevo=$request->value;
                similar_text($leyenda_ant, $leyenda_nuevo, $percent);
                if (number_format($percent, 0) < 80){
                    $locales = Locale::where('language','<>','es')->get();
                    $actualizado_data=array('actualizado'=>0);
                    foreach($locales as $locale)
                    {
                        App::setLocale($locale->language);
                        $modelo_object->update($actualizado_data);
                    }
                }
            }
            App::setLocale($request->pk);
            $campo=$request->name;
            $leyenda_data=array($campo=>$request->value,'actualizado'=>1);
            $modelo_object->update($leyenda_data);
            $message='la información fue actualizada correctamente';
            $titulo='LEYENDA ACTUALIZADA';
            //return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "actualizado"=>$request->actualizado, "atractivo"=>$request->atractivo_id, "idioma"=>$request->language, "locale_id"=>$request->locale_id, "language_titulo"=>$request->language_titulo]);
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "imagen"=>$id, "idioma"=>$request->pk, "nombre"=>"tour"]);
        }
	}

	public function destroy(Request $request, $id)
	{
        $modelo=$request->model;
        $modelo_object = \App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->findOrfail($id);
        $message= 'El recurso fue eliminado de la base de datos';
        $modelo_object->delete();
        Session::flash('message',$message);
        return redirect()->back();
	}

}
