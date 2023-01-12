<?php namespace Sivot\Modelos\Editor\Usuarios;

use Cartalyst\Sentinel\Users\EloquentUser as EloquentUser;

class User extends EloquentUser
{
    public function agencia()
    {
        return $this->hasOne('Sivot\Modelos\Editor\Agencias\Agencia');
    }

    public static function filterAndPaginate($nombre/*, $type*/)
    {
        return User::name($nombre)
            //->type($type)
            ->orderBy('id','ASC')
            ->with('roles')
            ->with('agencia')
            ->paginate();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' .$this->last_name;
    }

    /*public function setPasswordAttribute($value)
    {
        if (!empty($value))
        {
            return $this->attributes['password'] = bcrypt($value);
        }
    }*/

    public function scopeName($query, $name)
    {
        if (trim($name)!='')
        {
            $query->where(\DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE',"%$name%");
        }

    }

    /*public function scopeType($query, $type)
    {
        $types = config('options.type');
        if (trim($type)!='' && isset($types[$type]))
        {
            $query->where('type',$type);
        }

    }*/

}
