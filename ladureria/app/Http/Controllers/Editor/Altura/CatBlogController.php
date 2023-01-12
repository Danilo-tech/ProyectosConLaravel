<?php namespace Sivot\Http\Controllers\Editor\Altura;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Sivot\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Sivot\Http\Librerias\CaracteresEspeciales;
use Sivot\Modelos\Locales\Locale;

class CatBlogController extends Controller {

    public function traductor($idelemento, $language, $operacion, $modelo)
    {
        $modelo_data=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->findOrfail($idelemento);
        $incluidos=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->fields_edit_included;
        $locale = Locale::findOrfail($language);
        $fields = [];
        $estructura_tabla = \DB::select('SHOW FULL COLUMNS FROM ' . \App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->table_t);
        foreach ($estructura_tabla as $field) {
            $elemento = new \stdClass();
            if (substr($field->Field, strlen($field->Field) - 4, 4) == '_old'){
                $campo_old=$field->Field;
                $campo=substr($field->Field,0, strlen($field->Field) - 4);
                if (in_array($campo, $incluidos)) {
                    $elemento->valor_old = CaracteresEspeciales::htmlDiff($modelo_data->translate($locale->language)->$campo_old, $modelo_data->translate('es')->$campo);
                    if (array_key_exists($campo, \App::make("Sivot\Modelos\Editor\Altura\\" . $modelo)->fields_validators))
                        $elemento->validar = \App::make("Sivot\Modelos\Editor\Altura\\" . $modelo)->fields_validators[$campo];
                    else
                        $elemento->validar = [];
                    $elemento->valor = $campo;
                    $elemento->etiqueta = ucfirst(str_replace('_', ' ', $campo));
                    if (strpos($field->Type, 'varchar') !== false) $elemento->tipo = 'varchar';
                    else $elemento->tipo = 'textarea';
                    $fields[] = $elemento;
                }
            }
        }
//        dd($fields);
        $datos=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->getDatos();
        //$nombre_old = CaracteresEspeciales::htmlDiff($catblog->translate($locale->language)->nombre_old, $catblog->translate('en')->nombre);
        return view('editor.altura.translate_tabla', compact('modelo_data','locale','operacion','fields','datos','modelo'));
    }

    public function createcb($idprincipal, $idsecundario, $modelo, Request $request)
    {
        if ($request->ajax()) {
            $principal=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->principal;
            $secundario=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->secundario;
            $model_object=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->create([$principal=>$idprincipal,$secundario=>$idsecundario]);
            $message='La informacion de actualizo correctamente';
            $titulo='Actualizado';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "identificador"=>$model_object->id]);
        }
    }

    public function deletecb($idprincipal, $idsecundario, $modelo, Request $request)
    {
        if ($request->ajax()) {
            $model_object=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo);
            $principal=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->principal;
            $secundario=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->secundario;
            $model_object::where($principal,$idprincipal)->where($secundario,$idsecundario)->delete();
            $message='La informacion de actualizo correctamente';
            $titulo='Actualizado';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message]);
        }
    }

    public function updatecantidad(Request $request){
        if ($request->ajax()) {
            $modelo=$request->model;
            $model_object=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->findOrfail($request->pk);
            $campo=$request->name;
            $update_data=array($campo=>$request->value);
            $model_object->update($update_data);
            $message='La informacion se actualizo correctamente';
            $titulo='INFORMACION ACTUALIZADO';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message , "identificador"=>$model_object->id]);
        }
    }

    public function index(Request $request)
    {
        $fields=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->getFieldsIndex();
        //dd($fields);
        $datos=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->getDatos();
        $registros=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->all();
        //dd($fields);
        //$catblog = CatBlog::select('cat_blog.*')->join('cat_blog_translations','cat_blog.id','=','cat_blog_translations.cat_blog_id')->where('cat_blog_translations.locale_id',1)->OrderBy('nombre','Asc')->paginate();
        $locales = Locale::where('language','<>','es')->get();
        $modelo=$request->model;
        return view('editor.altura.index_table', compact('fields','locales','datos','registros','modelo'));
    }

    public function create(Request $request)
    {
        if ($request->padre!=null) {
            $padre = $request->padre;
            $padre_model = $request->model_padre;
            $padre_info = \App::make("Sivot\Modelos\Editor\Altura\\".$padre_model)->findOrfail($padre);
            $padre_datos = \App::make("Sivot\Modelos\Editor\Altura\\".$padre_model)->getDatos();
        }

        $fields=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->getFieldsCreate();
        //dd($fields);
        $datos=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->getDatos();
        $modelo=$request->model;
        //procedemos a traer la informacion la teral
        $laterales=[];
        $relaciones_laterales=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->getModeloRelacionesLaterales();
        if (count($relaciones_laterales)>0){
            foreach ($relaciones_laterales as $key => $value){
                $el= new \stdClass();
                $el->titulo=$key;
                $el->data=\App::make("Sivot\Modelos\Editor\Altura\\".$value[0])->all();
                $el->modeldata=\App::make("Sivot\Modelos\Editor\Altura\\".$value[0])->getDatos();
                $el->funcion=$value[1];
                $el->union=$value[2];
                $laterales[]=$el;
            }
        }

        return view('editor.altura.create_table', compact('fields','datos','modelo','laterales','padre','padre_model','padre_info','padre_datos'));
    }

    public function store(Request $request)
    {
        $modelo=$request->modelo;
        $model_object=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo);
        $nuevo=$model_object::create($request->all());

        //procesamos las imagenes
        $imagenes=explode('|', $request->imagenes);
        foreach ($imagenes as $image){
            if (trim($image)!=""){
                if(Input::file($image)!=null){
                    $prefijo = rand(10000, 99999) . '_';
                    $imagen = Image::make(Input::file($image));
                    $imagen->save('imagenes/blog/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file($image)->getClientOriginalName()));
                    $ruta = 'imagenes/blog/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file($image)->getClientOriginalName());
                    $image_data = array($image => $ruta);
                    $nuevo->update($image_data);
                }
            }
        }

        //procesamos los laterales
        $relaciones_laterales=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->getModeloRelacionesLaterales();
        if (count($relaciones_laterales)>0){
            foreach ($relaciones_laterales as $key => $value){
                $entrantes=$value[1];
                $valores=$request->$entrantes;
                if (!empty($valores) and count($valores)>0){
                    foreach ($valores as $valor)
                    {
                        //traemos el modelo de la tabla union
                        $modelo_union=\App::make("Sivot\Modelos\Editor\Altura\\".$value[2]);
                        $principal=\App::make("Sivot\Modelos\Editor\Altura\\".$value[2])->principal;
                        $secundario=\App::make("Sivot\Modelos\Editor\Altura\\".$value[2])->secundario;
                        $modelo_union::create([$principal=>$nuevo->id,$secundario=>$valor]);
                    }
                }
            }
        }

        $message='La informacion se registro correctamente';
        Session::flash('message',$message);
        if ($request->padre!=null)
            return redirect()->route('editor.altura.catblog.edit',['id'=>$request->padre,'model'=>$request->padre_model]);
        else
        return redirect()->route('editor.altura.catblog.index',['model'=>$modelo]);
    }

    public function edit(Request $request, $id)
    {
        if ($request->padre!=null) {
            $padre = $request->padre;
            $padre_model = $request->model_padre;
            $padre_info = \App::make("Sivot\Modelos\Editor\Altura\\".$padre_model)->findOrfail($padre);
            $padre_datos = \App::make("Sivot\Modelos\Editor\Altura\\".$padre_model)->getDatos();
        }
        $modelo=$request->model;
        $fields=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->getFieldsUpdate();
        //dd($fields);
        $datos=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->getDatos();
        //procedemos a traer la informacion la teral
        $laterales=[];
        $model_data=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->findOrfail($id);
        $relaciones_laterales=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->getModeloRelacionesLaterales();
        if (count($relaciones_laterales)>0){
            foreach ($relaciones_laterales as $key => $value){
                $el= new \stdClass();
                $el->titulo=$key;
                $el->data=\App::make("Sivot\Modelos\Editor\Altura\\".$value[0])->all();
                $el->modeldata=\App::make("Sivot\Modelos\Editor\Altura\\".$value[0])->getDatos();
                $el->funcion=$value[1];
                $el->union=$value[2];
                $el->tipo=$value[3];
                $el->secundario=\App::make("Sivot\Modelos\Editor\Altura\\".$value[2])->secundario;
                if ($value[3]=="cantidad")
                    $el->cantidad=\App::make("Sivot\Modelos\Editor\Altura\\".$value[2])->adicional;
                else
                    $el->cantidad="";
                $laterales[]=$el;
            }
        }

        //procedemos a traer la informacion debajo del cuerpo
        $cuerpos=[];
        $relaciones_cuerpos=\App::make("Sivot\Modelos\Editor\Altura\\".$request->model)->getRelacionesCuerpo();
        if (count($relaciones_cuerpos)>0){
            foreach ($relaciones_cuerpos as $key => $value){
                $el= new \stdClass();
                $el->titulo=$key;
                $el->fields=\App::make("Sivot\Modelos\Editor\Altura\\".$value[0])->getFieldsIndex();
                $el->datos=\App::make("Sivot\Modelos\Editor\Altura\\".$value[0])->getDatos();
                $funcion=$value[1];
                $el->funcion=$funcion;
                $el->validar=\App::make("Sivot\Modelos\Editor\Altura\\".$value[0])->validar;
                $el->modelo=$value[0];
                $el->tipo=$value[2];
                $cuerpos[]=$el;
            }
        }
        $locales = Locale::where('language','<>','es')->get();
        //dd($cuerpos);
        return view('editor.altura.edit_table', compact('fields','datos','modelo','laterales', 'model_data','cuerpos','locales','padre','padre_model','padre_info','padre_datos'));
    }

    public function update(Request $request,$id)
    {
        if ($request->ajax()){
            \App::setLocale($request->language);
            $modelo=$request->modelo;
            $model_data=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->findOrfail($id);
            $model_data->update($request->all());
            $message='la información fue actualizada correctamente';
            $titulo='TRADUCCIÓN ACTUALIZADA';
            return response()->json(["titulo"=>$titulo, "mensaje"=>$message, "actualizado"=>$request->actualizado, "elemento"=>$request->elemento_id, "idioma"=>$request->language, "locale_id"=>$request->locale_id, "language_titulo"=>$request->language_titulo]);
        }else {
            $modelo=$request->modelo;
            $model_data=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->findOrfail($id);
            $fields=\App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->getFieldsUpdate();
            $actualizar_old=[];
            foreach ($fields as $field){
                if ($field->traducir){
                    $campo=$field->field;
                    $actualizar_old[$field->field."_old"]=$model_data->$campo;
                }
            }
            $model_data->fill($request->all());
            $model_data->save();
            if ($request->actualizado_general!=NULL)
            {
                $locales = Locale::where('language','<>','es')->get();
                $actualizado_data=array('actualizado'=>0);
                foreach($locales as $locale)
                {
                    \App::setLocale($locale->language);
                    if ($model_data->actualizado==1)
                    {
                        $model_data->update($actualizar_old);
                    }
                    $model_data->update($actualizado_data);
                }
            }

            //procesamos las imagenes
            $imagenes=explode('|', $request->imagenes);
            foreach ($imagenes as $image){
                if (trim($image)!=""){
                    if(Input::file($image)!=null){
                        $prefijo = rand(10000, 99999) . '_';
                        $imagen = Image::make(Input::file($image));
                        $imagen->save('imagenes/blog/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file($image)->getClientOriginalName()));
                        $ruta = 'imagenes/blog/' . $prefijo . CaracteresEspeciales::ValidarNombreImagen(Input::file($image)->getClientOriginalName());
                        $image_data = array($image => $ruta);
                        $model_data->update($image_data);
                    }
                }
            }
            \App::setLocale('es');
            $message = 'La informacion fue actualizada correctamente';
            Session::flash('message', $message);
            return redirect()->back();
        }
    }

    public function destroy(Request $request,$id)
    {
        $modelo=$request->model;
        $modelo_object = \App::make("Sivot\Modelos\Editor\Altura\\".$modelo)->findOrfail($id);
        $message= 'El elemento fue eliminado de la base de datos';
        $modelo_object->delete();
        Session::flash('message',$message);
        return redirect()->back();
        //return redirect()->route('editor.altura.catblog.index',['model'=>$modelo]);
    }
}