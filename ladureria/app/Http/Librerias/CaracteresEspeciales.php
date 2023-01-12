<?php namespace Sivot\Http\Librerias;

class CaracteresEspeciales{

    public static function getFieldsIndex($table, $table_t = null, $field_index)
    {
        $fields = [];
        $estructura_tabla = \DB::select('SHOW FULL COLUMNS FROM ' . $table);
        if ($table_t != null) $estructura_tabla_translation = \DB::select('SHOW FULL COLUMNS FROM ' . $table_t);
        foreach ($estructura_tabla as $field) {
            if ($field->Key != 'PRI') {
                if ($field->Field != 'created_at' && $field->Field != 'updated_at') {
                    if (in_array($field->Field, $field_index)) {
                        $elemento = new \stdClass();
                        $elemento->field = $field->Field;
                        $elemento->tipo = $field->Type;
                        $elemento->orden = array_search($field->Field, $field_index);
                        $elemento->etiqueta = ucfirst(str_replace('_', ' ', $field->Field));
                        if (strpos($field->Field, 'imagen') === false) {
                            if (strpos($field->Type, 'varchar') === false) {
                                if (strpos($field->Type, 'tinyint') === false && strpos($field->Type, 'double') === false) {
                                    if (strpos($field->Type, 'int') === false) {
                                        $elemento->mostrar = 'options';
                                    } else {
                                        if ($field->Key == 'MUL') {
                                            $elemento->mostrar = 'relacion';
                                        } else $elemento->mostrar = 'text';
                                    }
                                } else $elemento->mostrar = 'text';
                            } else $elemento->mostrar = 'text';
                        } else $elemento->mostrar = 'imagen';
                        $fields[$field->Field] = $elemento;
                    }
                }
            }
        }

        if ($table_t != null){
            foreach ($estructura_tabla_translation as $field) {
                if ($field->Key != 'PRI' && $field->Key != 'MUL') {
                    if ($field->Field != 'created_at' && $field->Field != 'updated_at' && $field->Field != 'actualizado' && $field->Field != 'updated_at' && substr($field->Field, strlen($field->Field) - 4, 4) != '_old') {
                        if (in_array($field->Field, $field_index)) {
                            $elemento = new \stdClass();
                            $elemento->field = $field->Field;
                            $elemento->tipo = $field->Type;
                            $elemento->orden = array_search($field->Field, $field_index);
                            $elemento->etiqueta = ucfirst(str_replace('_', ' ', $field->Field));
                            $elemento->mostrar = 'text';
                            $fields[$field->Field] = $elemento;
                        }
                    }
                }
            }
        }

        uasort($fields, function($a, $b)
        {
            return ($a->orden-$b->orden) ? ($a->orden-$b->orden)/abs($a->orden-$b->orden) : 0;

        });

        return $fields;
    }
    public static function burbuja($array)
    {
        for($i=1;$i<count($array);$i++)
        {
            for($j=0;$j<count($array)-$i;$j++)
            {
                if($array[$j]->orden>$array[$j+1]->orden)
                {
                    $k=$array[$j+1];
                    $array[$j+1]=$array[$j];
                    $array[$j]=$k;
                }
            }
        }
        return $array;
    }

    public static function getFieldsCreate($table, $table_t = null, $fields_excluded, $validators){
        $fields = [];
        $estructura_tabla = \DB::select('SHOW FULL COLUMNS FROM ' . $table);
        if ($table_t != null) $estructura_tabla_translation = \DB::select('SHOW FULL COLUMNS FROM ' . $table_t);
        foreach ($estructura_tabla as $field) {
            if ($field->Key != 'PRI') {
                if ($field->Field != 'created_at' && $field->Field != 'updated_at') {
                    if (in_array($field->Field, $fields_excluded)) {
                        $elemento = new \stdClass();
                        $elemento->field = $field->Field;
                        $elemento->tipo = $field->Type;
                        $elemento->etiqueta = ucfirst(str_replace('_', ' ', $field->Field));
                        if (array_key_exists($field->Field,$validators))
                        $elemento->validacion = $validators[$field->Field];
                        else
                        $elemento->validacion = [];
                        $elemento->traducir = false;
                        $elemento->orden = array_search($field->Field, $fields_excluded);
                        if (strpos($field->Field, 'imagen') === false) {
                            if (strpos($field->Type, 'varchar') === false) {
                                if (strpos($field->Type, 'double') === false) {
                                    if (strpos($field->Type, 'int') === false) {
                                        if (strpos($field->Type, 'textarea') === false && strpos($field->Type, 'mediumtext') === false)
                                            if (strpos($field->Type, 'char') === false)
                                                $elemento->mostrar = 'varchar';
                                            else $elemento->mostrar = 'select';
                                        else $elemento->mostrar = 'textarea';
                                    } else {
                                        if ($field->Key == 'MUL') {
                                            $elemento->mostrar = 'relacion';
                                        } else $elemento->mostrar = 'updown';
                                    }
                                } else $elemento->mostrar = 'varchar';
                            } else $elemento->mostrar = 'varchar';
                        } else $elemento->mostrar = 'imagen';
                        $fields[$field->Field] = $elemento;
                    }
                }
            }
        }

        if ($table_t != null){
            foreach ($estructura_tabla_translation as $field) {
                if ($field->Key != 'PRI' && $field->Key != 'MUL') {
                    if ($field->Field != 'created_at' && $field->Field != 'updated_at' && $field->Field != 'actualizado' && $field->Field != 'updated_at' && substr($field->Field, strlen($field->Field) - 4, 4) != '_old') {
                        if (in_array($field->Field, $fields_excluded)) {
                            $elemento = new \stdClass();
                            $elemento->field = $field->Field;
                            $elemento->tipo = $field->Type;
                            $elemento->etiqueta = ucfirst(str_replace('_', ' ', $field->Field));
                            if (array_key_exists($field->Field,$validators))
                                $elemento->validacion = $validators[$field->Field];
                            else
                                $elemento->validacion = [];
                            $elemento->traducir = true;
                            $elemento->orden = array_search($field->Field, $fields_excluded);
                            if (strpos($field->Type, 'varchar') === false)
                                $elemento->mostrar = 'textarea';
                            else $elemento->mostrar = 'varchar';

                            $fields[$field->Field] = $elemento;
                        }
                    }
                }
            }
        }

        uasort($fields, function($a, $b)
        {
            return ($a->orden-$b->orden) ? ($a->orden-$b->orden)/abs($a->orden-$b->orden) : 0;

        });

        return $fields;
    }

    public static function getFieldsUpdate($table, $table_t = null, $fields_excluded, $validators){
        $fields = [];
        $estructura_tabla = \DB::select('SHOW FULL COLUMNS FROM ' . $table);
        if ($table_t != null) $estructura_tabla_translation = \DB::select('SHOW FULL COLUMNS FROM ' . $table_t);
        foreach ($estructura_tabla as $field) {
            if ($field->Key != 'PRI') {
                if ($field->Field != 'created_at' && $field->Field != 'updated_at') {
                    if (in_array($field->Field, $fields_excluded)) {
                        $elemento = new \stdClass();
                        $elemento->field = $field->Field;
                        $elemento->tipo = $field->Type;
                        $elemento->etiqueta = ucfirst(str_replace('_', ' ', $field->Field));
                        if (array_key_exists($field->Field,$validators))
                            $elemento->validacion = $validators[$field->Field];
                        else
                            $elemento->validacion = [];
                        $elemento->traducir = false;
                        $elemento->orden = array_search($field->Field, $fields_excluded);
                        if (strpos($field->Field, 'imagen') === false) {
                            if (strpos($field->Type, 'varchar') === false) {
                                if (strpos($field->Type, 'double') === false) {
                                    if (strpos($field->Type, 'int') === false) {
                                        if (strpos($field->Type, 'textarea') === false && strpos($field->Type, 'mediumtext') === false)
                                            if (strpos($field->Type, 'char') === false)
                                                $elemento->mostrar = 'varchar';
                                            else $elemento->mostrar = 'select';
                                        else $elemento->mostrar = 'textarea';
                                    } else {
                                        if ($field->Key == 'MUL') {
                                            $elemento->mostrar = 'relacion';
                                        } else $elemento->mostrar = 'updown';
                                    }
                                } else $elemento->mostrar = 'varchar';
                            } else $elemento->mostrar = 'varchar';
                        } else $elemento->mostrar = 'imagen';
                        $fields[$field->Field] = $elemento;
                    }
                }
            }
        }

        if ($table_t != null){
            foreach ($estructura_tabla_translation as $field) {
                if ($field->Key != 'PRI' && $field->Key != 'MUL') {
                    if ($field->Field != 'created_at' && $field->Field != 'updated_at' && $field->Field != 'actualizado' && $field->Field != 'updated_at' && substr($field->Field, strlen($field->Field) - 4, 4) != '_old') {
                        if (in_array($field->Field, $fields_excluded)) {
                            $elemento = new \stdClass();
                            $elemento->field = $field->Field;
                            $elemento->tipo = $field->Type;
                            $elemento->etiqueta = ucfirst(str_replace('_', ' ', $field->Field));
                            if (array_key_exists($field->Field,$validators))
                                $elemento->validacion = $validators[$field->Field];
                            else
                                $elemento->validacion = [];
                            $elemento->traducir = true;
                            $elemento->orden = array_search($field->Field, $fields_excluded);
                            if (strpos($field->Type, 'varchar') === false)
                                $elemento->mostrar = 'textarea';
                            else $elemento->mostrar = 'varchar';

                            $fields[$field->Field] = $elemento;
                        }
                    }
                }
            }
        }

        uasort($fields, function($a, $b)
        {
            return ($a->orden-$b->orden) ? ($a->orden-$b->orden)/abs($a->orden-$b->orden) : 0;

        });

        return $fields;
    }

    public static function ValidarNombreImagen($nombre)
    {
        $string = trim($nombre);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
                "#", "@", "|", "!", "\"",
                "·", "$", "%", "&", "/",
                "(", ")", "?", "'", "¡",
                "¿", "[", "^", "`", "]",
                "+", "}", "{", "¨", "´",
                ">", "< ", ";", ",", ":"),
            '',
            $string
        );

        return $string;
    }

    public static function ValidarNombreCarpeta($nombre)
    {
        $string = trim($nombre);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C',),
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "-", "~",
                "#", "@", "|", "!", "\"",
                "·", "$", "%", "&", "/",
                "(", ")", "?", "'", "¡",
                "¿", "[", "^", "`", "]",
                "+", "}", "{", "¨", "´",
                ">", "< ", ";", ",", ":", ".", " "),
            '',
            $string
        );

        return strtolower($string);
    }

    public static function diff($old, $new){
        $matrix = array();
        $maxlen = 0;
        foreach($old as $oindex => $ovalue){
            $nkeys = array_keys($new, $ovalue);
            foreach($nkeys as $nindex){
                $matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
                    $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
                if($matrix[$oindex][$nindex] > $maxlen){
                    $maxlen = $matrix[$oindex][$nindex];
                    $omax = $oindex + 1 - $maxlen;
                    $nmax = $nindex + 1 - $maxlen;
                }
            }
        }
        if($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
        return array_merge(
            CaracteresEspeciales::diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),
            array_slice($new, $nmax, $maxlen),
            CaracteresEspeciales::diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
    }

    public static function htmlDiff($old, $new){
        // put space in front and behind tags, or they are seen as a word when replacing the one behind it or in front
        $old = str_replace(array("<",">"), array(" <", "> "), $old);
        $new = str_replace(array("<",">"), array(" <", "> "), $new);

        $ret = '';
        $diff = CaracteresEspeciales::diff(explode(' ', $old), explode(' ', $new));
        foreach($diff as $k){
            if(is_array($k))
                $ret .= (!empty($k['d'])?"<del style='background-color:#ffcccc'>".implode(' ',$k['d'])."</del> ":'').
                    (!empty($k['i'])?"<ins style='background-color:#ccffcc'>".implode(' ',$k['i'])."</ins> ":'');
            else $ret .= $k . ' ';
        }
        return $ret;
    }

    public static function url_amigable($url) {
        // Tranformamos todo a minusculas
        $url = strtolower(trim($url));
        //Rememplazamos caracteres especiales latinos
        $find = array('�', '�', '�', '�', '�', '�');
        $repl = array('a', 'e', 'i', 'o', 'u', 'n');
        $url = str_replace ($find, $repl, $url);
        // Anaadimos los guiones
        $find = array(' ', '&', '\r\n', '\n', '+');
        $url = str_replace ($find, '-', $url);
        // Eliminamos y Reemplazamos dem�s caracteres especiales
        $find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
        $repl = array('', '-', '');
        $url = preg_replace ($find, $repl, $url);

        $url = preg_replace( '/  +/', ' ', $url);

        return $url;
    }

}