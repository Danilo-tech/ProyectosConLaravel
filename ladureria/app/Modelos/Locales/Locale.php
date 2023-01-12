<?php namespace Sivot\Modelos\Locales;

use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    //protected $table = 'locales'; //esto es opcional ya que toma el nombre de la clase para encontrar el nombre de la tabla (minuscula y plural)
    protected $fillable = ['language'];
}