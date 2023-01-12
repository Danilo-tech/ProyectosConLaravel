<?php
namespace Sivot\Http\Controllers;


use Sivot\Atractivo;
use Sivot\User;

class UsersController extends Controller{

    public function getOrm()
    {
        $atractivos = Atractivo::select('id', 'nombre','informacion','distancia_cusco','msnm','ingreso')
            ->with('secciones')
            ->orderBy('nombre','ASC')
            ->get();
        //$result = Atractivo::get();
        dd($atractivos->toArray());


        //return $result;
    }

    public function getIndex()
    {
        /*$result = \DB::table('users')
            ->select('first_name','last_name')
            ->where('first_name', '<>', 'Dann')
            ->orderBy('first_name', 'ASC')
            ->get();*/

        $result = \DB::table('atractivos')
            ->select('atractivos.*','atractivo_secciones.nombre as nombre_seccion','atractivo_secciones.informacion as informacion_seccion')
            //->where('first_name', '<>', 'Dann')
            ->orderBy('atractivos.nombre', 'ASC')
            ->join('atractivo_secciones', 'atractivos.id', '=', 'atractivo_secciones.atractivo_id')
            ->get();

        dd($result);

        return $result;
    }

}