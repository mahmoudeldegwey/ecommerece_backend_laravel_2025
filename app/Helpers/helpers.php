<?php 
use App\Repositories\Interfaces\SettingInterFace;

if (!function_exists('get_unique_id')) {
    /**
     * @param array $args
     * @return array|mixed
     */
    function get_unique_id($length , $format = 'num|alpha|upperalpha|symb')
    {
        $length = (int)$length;
        $format_parts = explode("|", $format);

        if ($length == 0 || sizeof($format_parts) == 0) {
            return false;
        }

        $sh = '';

        if (in_array('num', $format_parts)) {
            $sh .= str_replace(array(' ', '.'), array('', ''), microtime()) . '12345678900987654321';
        }

        if (in_array('alpha', $format_parts)) {
            $sh .= 'abcdefghijklmnopqrstuvwxyzzyxwvutsrqponmlkjihgfedcba';
        }

        if (in_array('upperalpha', $format_parts)) {
            $sh .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZZYXWVUTSRQPONMLKJIHGFEDCBA';
        }

        if (in_array('symb', $format_parts)) {
            $sh .= '_$#*.!@=-+~^^~+-=@!.*#$_';
        }

        if ($length >= strlen($sh)) {
            $sh = str_shuffle($sh . strrev($sh));
        }

        $rand = str_shuffle(str_shuffle(str_shuffle(str_shuffle($sh))));

        $randpos = mt_rand(1, strlen($rand) - $length);

        $token = substr($rand, $randpos, $length);

        $token = ltrim($token, '0');

        return $token;
    }
}

if (!function_exists('filter_array')) {
    function filter_array($value){
        if (is_array($value)) {
            $value = array_values(array_filter($value));
            $value = remove_empty_values_array($value);
        }
        return $value;
    }
}

if (!function_exists('remove_empty_values_array')) {
    function remove_empty_values_array($value){
        if(($key = array_search("null",$value)) !== false) {
            unset($value[$key]);
        } 

        return $value;
    }
}

if (!function_exists('format_date')) {
    function format_date($date){
        return date('Y-m-d H:i:s', strtotime($date));
    }
}

if (!function_exists('setting')) {
    function setting($key){
        try {
        
            return app(SettingInterFace::class)->getFirstBy(['key' => $key],['value'])?->value;  //?-> handle null value          

        } catch (\Exception $e) {
            return null;
        }
    }
}