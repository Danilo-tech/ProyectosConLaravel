<?php
/**
 * Created by PhpStorm.
 * User: area de informatica
 * Date: 08/04/2015
 * Time: 10:33 AM
 */

namespace Sivot\Http\Middleware;


class IsAdmin extends IsType{

    public function getType()
    {
        return 'admin';
    }

}