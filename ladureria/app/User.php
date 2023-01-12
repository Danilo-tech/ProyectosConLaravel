<?php namespace Sivot;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Sivot\Modelos\Editor\Bpe\Docentes;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['first_name', 'last_name', 'email', 'password', 'type'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    public function perfil()
    {
        return $this->hasOne('Sivot\Modelos\Editor\Bpe\Docentes' ,'user_id', 'id');
    }

    public static function filterAndPaginate($name, $estado)
    {
        $perfiles=Docentes::all()->lists('user_id');
        return User::select('users.*','activations.completed')
            ->join('activations','activations.user_id','=','users.id')
            ->join('role_users','role_users.user_id','=','users.id')
            ->where('role_id','<>','1')
            ->where('role_id','<>','4')
            ->where('role_id','<>','5')
            ->where('role_id','<>','6')
            ->where('role_id','<>','7')
            ->where('role_id','<>','8')
            ->where('role_id','<>','9')
            ->name($name)
            ->estado($estado)
            ->whereNotIn('users.id', $perfiles)
            ->orderBy('id','DESC')
            ->paginate();
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' .$this->last_name;
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value))
        {
            return $this->attributes['password'] = bcrypt($value);
        }
    }

    public function scopeName($query, $name)
    {
        if (trim($name)!='')
        {
            $query->where(\DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE',"%$name%");
        }

    }

    public function scopeEstado($query, $estado)
    {
        if (trim($estado)!='')
        {
            $query->where('activations.completed',$estado);
        }

    }

    public function scopeType($query, $type)
    {
        $types = config('options.type');
        if (trim($type)!='' && isset($types[$type]))
        {
            $query->where('type',$type);
        }

    }

    public function isAdmin()
    {
        return $this->type === 'admin';
    }

    public function is($type)
    {
        return $this->type === $type;
    }

}
