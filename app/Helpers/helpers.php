<?php 
use App\Repositories\Interfaces\SettingInterFace;
use App\Models\{City,Country};

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

// if (!function_exists('formatCurrency')) {
//     function formatCurrency(float $amount): string
//     {
//         $formatter = new NumberFormatter(setting('default_currency'), NumberFormatter::CURRENCY);
//         return $formatter->formatCurrency($amount, setting('default_currency'));
//     }
// }

if (!function_exists('formatCurrency')) {
    function formatCurrency(float $amount): string
    {
        $currency = setting('default_currency') ?? 'USD';

        return number_format($amount, 2) . ' ' . strtoupper($currency);
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


/**
 * Parse address JSON to array
 */
if(!function_exists('parseBillingAddress')){
    function parseBillingAddress($address): ?array
    {
        if (is_array($address)) {
            return $address;
        }

        if (is_string($address)) {
            return json_decode($address, true);
        }

        return null;
    }
}

/**
 * Format address for display
 */
if(!function_exists('format')){
    function format(?array $address): string
    {
        if (!$address) {
            return 'N/A';
        }

        $lines = [];

        // Name
        if (isset($address['username'])) {
            $lines[] = $address['username'];
        }

        // Phone
        if (isset($address['phone'])) {
            $lines[] = 'Phone: ' . $address['phone'];
        }

        // Street Address
        if (isset($address['address'])) {
            $lines[] = $address['address'];
        }

        // City and Country
        $location = [];
        
        if (isset($address['city'])) {
            $location[] = $address['city'];
        } elseif (isset($address['city_id'])) {
            $city = City::find($address['city_id']);
            if ($city) {
                $location[] = $city->name;
            }
        }

        if (isset($address['country'])) {
            $location[] = $address['country'];
        } elseif (isset($address['country_id'])) {
            $country = Country::find($address['country_id']);
            if ($country) {
                $location[] = $country->name;
            }
        }

        if (!empty($location)) {
            $lines[] = implode(', ', $location);
        }

        return implode("\n", $lines);
    }
}

/**
 * Get city name from address
 */
if(!function_exists('getCityName')){
    function getCityName($city_id): ?string
    {
        return City::find($city_id)?->name;
    }
}

/**
 * Get country name from address
 */
if(!function_exists('getCountryName')){
    function getCountryName($country_id): ?string
    {
        return Country::find($country_id)?->name;
    }
}

/**
 * Check if two addresses are the same
 */
if(!function_exists('areSame')){
    function areSame(?array $address1, ?array $address2): bool
    {
        if (!$address1 || !$address2) {
            return false;
        }

        // Compare relevant fields
        $fields = ['username', 'phone', 'address', 'city_id', 'country_id'];
        
        foreach ($fields as $field) {
            if (($address1[$field] ?? null) !== ($address2[$field] ?? null)) {
                return false;
            }
        }

        return true;
    }
}

/**
 * Get full address as single line
 */
if(!function_exists('getSingleLine')){
    function getSingleLine(?array $address): string
    {
        if (!$address) {
            return 'N/A';
        }

        $parts = [];

        if (isset($address['address'])) {
            $parts[] = $address['address'];
        }

        $city = getCityName($address);
        if ($city) {
            $parts[] = $city;
        }

        $country = getCountryName($address);
        if ($country) {
            $parts[] = $country;
        }

        return implode(', ', $parts);
    }
}