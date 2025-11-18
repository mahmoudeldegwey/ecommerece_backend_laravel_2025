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

if (!function_exists('format_price')) {
    function format_price(float $price){
        return strtoupper(setting('default_currency')) . formatCurrency($price) ;
    }
}

if(!function_exists('formatCurrency')){
    function formatCurrency(float $amount): string
    {
        $formatter = new NumberFormatter(setting('default_currency'), NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($amount, setting('default_currency'));
    }
}

if(!function_exists('getDiscountRate')){
    function getDiscountRate(float $sale_price, float $price )
    {
        return round((($price - $sale_price) / $price) * 100) ;
    }
}

if (!function_exists('avaliable_payment_methods')) {
    function avaliable_payment_methods(){
        return ["COD","instaPay","creditCard"];
    }
}

if(!function_exists('order_statuses')){
    function order_statuses (){
        return ['delivered','pending','confirmed','shipped','cancelled','refunded','completed'];
    }
}