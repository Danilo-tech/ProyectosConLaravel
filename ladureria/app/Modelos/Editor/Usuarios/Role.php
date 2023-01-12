<?php namespace Sivot\Modelos\Editor\Usuarios;

use Cartalyst\Sentinel\Roles\EloquentRole as EloquentRole;

class Role extends EloquentRole
{
    /*public function agencia()
    {
        return $this->hasMany('Sivot\Modelos\Editor\Proveedores\AlojamientoHabitacionesServicios');
    }*/

    public static function filterAndPaginate($nombre/*, $type*/)
    {
        return Role::name($nombre)
            //->type($type)
            ->orderBy('id','ASC')
            ->paginate();
    }

    public function scopeName($query, $name)
    {
        if (trim($name)!='')
        {
            $query->where('name','LIKE',"%$name%")->orwhere('slug','LIKE',"%$name%");
        }
    }

}
